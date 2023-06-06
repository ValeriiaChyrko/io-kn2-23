<?php

namespace App\Models;

use App\Filters\SoftwareModelFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\SoftwareModel
 *
 * @property int $id
 * @property string $title
 * @property Carbon|null $deleted_at
 * @property-read bool $is_deletable Indicates is software model can be deleted.
 * @property-read Collection|License[] $licenses
 * @property-read int|null $licenses_count
 * @mixin Eloquent
 */
class SoftwareModel extends Model
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
        return $this->licenses_count == 0;
    }

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return SoftwareModelFilter::class;
    }

    /**
     * Software model licenses, one-to-many relations.
     *
     * @return HasMany
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }
}
