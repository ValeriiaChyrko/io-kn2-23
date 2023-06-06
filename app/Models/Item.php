<?php

namespace App\Models;

use App\Filters\ItemFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Item
 *
 * @property int $id
 * @property int $type_id
 * @property int $hardware_model_id
 * @property int $department_id
 * @property int $owner_id
 * @property int $status_id
 * @property string|null $inventory_number
 * @property string|null $price
 * @property int $invoice_id
 * @property int $has_parts
 * @property int|null $part_of
 * @property int|null $writeoff_id
 * @property int|null $utilization_id
 * @property string|null $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Department $department
 * @property-read bool|null $is_repairable
 * @property-read bool|null $is_transferable
 * @property-read HardwareModel $hardwareModel
 * @property-read Invoice $invoice
 * @property-read Collection|License[] $licenses
 * @property-read int|null $licenses_count
 * @property-read Collection|Item[] $parts
 * @property-read int|null $parts_count
 * @property-read Item $parent
 * @property-read Collection|Repair[] $repairs
 * @property-read int|null $repairs_count
 * @property-read Status $status
 * @property-read User $user
 * @property-read Collection|Transfer[] $transfers
 * @property-read int|null $transfers_count
 * @property-read Type $type
 * @mixin Eloquent
 */
class Item extends Model
{
    use Filterable, HasFactory, SoftDeletes;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_repairable',
        'is_unrepairable'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'has_parts' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'part_of',
        'type_id',
        'hardware_model_id',
        'department_id',
        'owner_id',
        'status_id',
        'inventory_number',
        'price',
        'invoice_id',
        'has_parts',
        'writeoff_id',
        'utilization_id',
        'comment',
    ];

    /**
     * Accessor for is_transferable attribute.
     * Indicates is item can't be sent for transfer.
     *
     * @return bool|null
     */
    public function getIsTransferableAttribute(): ?bool
    {
        if(is_null($this->status_id)) {
            return null;
        }

        return in_array($this->status_id, [
            Status::STATUS_IN_USE
        ]);
    }

    /**
     * Accessor for is_repairable attribute.
     * Indicates is item can be sent for repair.
     *
     * @return bool|null
     */
    public function getIsRepairableAttribute(): ?bool
    {
        if(is_null($this->status_id)) {
            return null;
        }

        return in_array($this->status_id, [
            Status::STATUS_IN_USE
        ]);
    }

    /**
     * Accessor for is_unrepairable attribute.
     * Indicates is item can't be sent for repair.
     *
     * @return bool|null
     */
    public function getIsUnrepairableAttribute(): ?bool
    {
        if(is_null($this->is_repairable)) {
            return null;
        }

        return ! $this->is_repairable;
    }

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return ItemFilter::class;
    }

    /**
     * Item invoice, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Item licenses, one-to-many relations.
     *
     * @return HasMany
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    /**
     * Item parts, one-to-many relations.
     *
     * @return HasMany
     */
    public function parts(): HasMany
    {
        return $this->hasMany(Item::class, 'part_of', 'id');
    }

    /**
     * Item parent, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'part_of', 'id');
    }

    /**
     * Item repairs, one-to-many relations.
     *
     * @return HasMany
     */
    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }

    /**
     * Item transfers, many-to-many relations.
     *
     * @return BelongsToMany
     */
    public function transfers(): BelongsToMany
    {
        return $this->belongsToMany(Transfer::class);
    }

    /**
     * Item type, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Item hardware model, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function hardwareModel(): BelongsTo
    {
        return $this->belongsTo(HardwareModel::class);
    }

    /**
     * Item department, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Item status, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Item owner, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    /**
     * Get only parentable scope.
     *
     * @param Builder $query
     */
    public function scopeOnlyParentable(Builder $query)
    {
        $query->whereNull('items.part_of');
    }

    /**
     * Get only repairable scope.
     *
     * @param Builder $query
     */
    public function scopeOnlyRepairable(Builder $query)
    {
        $query->whereIn('items.status_id', [
            Status::STATUS_IN_USE
        ]);
    }

    /**
     * Get only transferable scope.
     *
     * @param Builder $query
     */
    public function scopeOnlyTransferable(Builder $query)
    {
        $query->whereIn('items.status_id', [
            Status::STATUS_IN_USE
        ]);
    }
}
