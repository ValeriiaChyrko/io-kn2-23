<?php

namespace App\Models;

use App\Filters\HardwareModelFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\HardwareModel
 *
 * @property int $id Record id.
 * @property string $title Hardware model title.
 * @property Carbon|null $deleted_at Timestamp when record was soft-deleted.
 * @property-read bool $is_deletable Indicates is hardware model can be deleted.
 * @property-read Collection|Item[] $items Collection of hardware model items, one-to-many relations.
 * @property-read int|null $items_count Hardware model items count.
 * @mixin Eloquent
 */
class HardwareModel extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_deletable'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * Accessor for is_deletable attribute.
     * Indicates is hardware model can be deleted.
     *
     * @return bool
     */
    public function getIsDeletableAttribute(): bool
    {
        return $this->items_count == 0;
    }

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return HardwareModelFilter::class;
    }

    /**
     * HardwareModel items, one-to-many relations.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
