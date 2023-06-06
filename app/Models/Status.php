<?php

namespace App\Models;

use App\Filters\StatusFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Status
 *
 * @property int $id
 * @property string $title
 * @property-read Collection|Item[] $items
 * @property-read int|null $items_count
 * @mixin Eloquent
 */
class Status extends Model
{
    use Filterable;

    public const STATUS_IN_USE = 1;
    public const STATUS_TRANSFERRING = 2;
    public const STATUS_REPAIRING = 3;
    public const STATUS_UNREPAIRABLE = 4;
    public const STATUS_WRITTEN_OFF = 5;
    public const STATUS_UTILIZED = 6;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return StatusFilter::class;
    }

    /**
     * Status items, one-to-many relations.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
