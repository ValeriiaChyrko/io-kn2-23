<?php

namespace App\Models;

use App\Filters\DepartmentFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Department
 *
 * @property int $id Record id.
 * @property string $title Department title.
 * @property int $parent_id The id of parent department.
 * @property Carbon|null $deleted_at Timestamp when record was soft-deleted.
 * @property-read bool $is_deletable Indicates is department can be deleted.
 * @property-read Collection|Department[] $children Collection of department childs, one-to-many relations.
 * @property-read int|null $children_count Department childs count.
 * @property-read Collection|Item[] $items Collection of department items, one-to-many relations.
 * @property-read int|null $items_count Department items count.
 * @property-read Department $parent Department parent, many-to-one relations.
 * @mixin Eloquent
 */
class Department extends Model
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
        'parent_id',
    ];

    /**
     * Accessor for is_deletable attribute.
     * Indicates is department can be deleted.
     *
     * @return bool
     */
    public function getIsDeletableAttribute(): bool
    {
        return $this->children_count == 0 and $this->items_count == 0;
    }

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return DepartmentFilter::class;
    }

    /**
     * Department parent, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id', 'id');
    }

    /**
     * Department childs, one-to-many relations.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id', 'id');
    }

    /**
     * Department items, one-to-many relations.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
