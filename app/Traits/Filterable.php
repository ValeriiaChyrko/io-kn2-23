<?php

namespace App\Traits;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method static static|Collection getFiltered()
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder filter()
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder autoJoin(array $tables)
 */
trait Filterable
{
    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeFilter(Builder $query): Builder
    {
        return $this->getFilterInstance()->filter($query);
    }

    /**
     * @param Builder $query
     * @return Collection
     */
    public function scopeGetFiltered(Builder $query): Collection
    {
        $filter = $this->getFilterInstance();
        $builder = $filter->filter($query);

        if ($filter->getPerPage() == -1) {
            return collect(['data' => $builder->get()]);
        } else {
            return collect($builder->paginate($filter->getPerPage()));
        }
    }

    /**
     * @param Builder $query
     * @param array $tables
     * @return Builder
     */
    public function scopeAutoJoin(Builder $query, array $tables): Builder
    {
        return $this->getFilterInstance()->join($query, $tables);
    }

    /**
     * Create a new filter instance for the model.
     *
     * @return QueryFilter
     */
    public function getFilterInstance(): QueryFilter
    {
        $filter = $this->getFilterClass();

        return app($filter);
    }

    /**
     * Return fully qualified name of the filter class.
     *
     * @return class-string
     */
    abstract protected function getFilterClass(): string;
}
