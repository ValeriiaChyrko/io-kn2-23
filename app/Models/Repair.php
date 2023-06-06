<?php

namespace App\Models;

use App\Filters\RepairFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Repair
 *
 * @property int $id Record id.
 * @property int $item_id The id of repaired item.
 * @property Carbon|null $start_date Repair start date.
 * @property Carbon|null $end_date Repair complete date.
 * @property int $user_id The id of user who is responsible for the repair.
 * @property int $provider_id The id of the provider who performs the repair.
 * @property Carbon|null $created_at Timestamp whe the record was created.
 * @property Carbon|null $updated_at Timestamp of tle last record update.
 * @property Carbon|null $deleted_at Timestamp when record was soft-deleted.
 * @property int|null $is_unrepairable Indicates is repair was unsuccessful and item can't be repaired.
 * @property string|null $comment Additional information about repair.
 * @property-read bool $is_deletable Indicates is repair can be deleted.
 * @property-read bool $is_completion_data_editable Indicates whether editing of completion information is allowed.
 * @property-read bool $is_completed Indicates whether the repair is completed.
 * @property-read Item $item Repaired item.
 * @property-read Provider $provider Provider who performs the repair.
 * @property-read User $user User who is responsible for the repair.
 * @mixin Eloquent
 */
class Repair extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_completed',
        'is_deletable'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_unrepairable' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'start_date',
        'end_date',
        'user_id',
        'provider_id',
        'is_unrepairable',
        'comment'
    ];

    /**
     * Accessor for is_deletable attribute.
     * Indicates is repair can be deleted.
     *
     * @return bool
     */
    public function getIsDeletableAttribute(): bool
    {
        return !$this->is_completed;
    }

    /**
     * Accessor for is_completion_data_editable attribute.
     * Indicates whether editing of completion information is allowed.
     *
     * @return bool
     */
    public function getIsCompletionDataEditableAttribute(): bool
    {
        return in_array($this->item->status_id, [
            Status::STATUS_IN_USE,
            Status::STATUS_UNREPAIRABLE
        ]);
    }

    /**
     * Accessor for is_repairable attribute.
     * Indicates whether the repair is completed.
     *
     * @return bool
     */
    public function getIsCompletedAttribute(): bool
    {
        //If end_date field is null, then repair is not completed yet
        return !is_null($this->end_date);
    }

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return RepairFilter::class;
    }

    /**
     * Repair item, many-to-one relation
     *
     * @return BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Repair user, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Repair provider, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
