<?php

namespace App\Models;

use App\Filters\TransferFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Transfer
 *
 * @property int $id
 * @property string $transfer_date
 * @property int $transfer_number
 * @property int $from_user_id
 * @property int $to_user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $file_url
 * @property int|null $confirmed
 * @property Carbon|null $deleted_at
 * @property-read User $from_user
 * @property-read Collection|Item[] $items
 * @property-read int|null $items_count
 * @property-read User $to_user
 * @mixin Eloquent
 */
class Transfer extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'transfer_date',
        'transfer_number',
        'from_user_id',
        'to_user_id',
        'file_url',
        'confirmed'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_deletable'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'confirmed' => 'boolean'
    ];

    /**
     * Accessor for is_deletable attribute.
     * Indicates is transfer can be deleted.
     *
     * @return bool
     */
    public function getIsDeletableAttribute(): bool
    {
        return is_null($this->confirmed);
    }

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return TransferFilter::class;
    }

    /**
     * Transfer items, many-to-many relations.
     *
     * @return BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }

    /**
     * Transfer sender, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function from_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }

    /**
     * Transfer receiver, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function to_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }
}
