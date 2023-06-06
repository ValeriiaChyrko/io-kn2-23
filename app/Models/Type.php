<?php

namespace App\Models;

use App\Filters\TypeFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Type
 *
 * @property int $id Record id.
 * @property string $title Type title.
 * @property Carbon|null $deleted_at Timestamp when record was soft-deleted.
 * @property-read bool $is_deletable Indicates is type can be deleted.
 * @property-read Collection|Item[] $items Collection of type items, one-to-many relations.
 * @property-read int|null $items_count Type items count.
 * @mixin Eloquent
 */
class Type extends Model
{
    use Filterable, SoftDeletes;

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
     * Indicates is type can be deleted.
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
        return TypeFilter::class;
    }

    /**
     * Type items, one-to-many relations.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
