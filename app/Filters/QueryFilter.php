<?php

namespace App\Filters;

use App\Exceptions\AutoJoinTablesArrayEmptyException;
use App\Exceptions\AutoJoinUnknownTableException;
use App\Exceptions\UndefinedFilterScopeException;
use Illuminate\Database\Eloquent\Builder;
use Str;

abstract class QueryFilter
{
    /**
     * The name of the "sortBy" parameter.
     *
     * @var string
     */
    private const SORT_BY_PARAMETER_NAME = 'sortBy';

    /**
     * The name of the "sortDirection" parameter.
     *
     * @var string
     */
    private const SORT_DIRECTION_PARAMETER_NAME = 'sortDirection';    //TODO: Add custom sort(float, numeric, date)

    /**
     * The name of the "search" parameter.
     *
     * @var string
     */
    private const SEARCH_PARAMETER_NAME = 'search';

    /**
     * The name of the "perPage" parameter.
     *
     * @var string
     */
    private const PER_PAGE_PARAMETER_NAME = 'perPage';

    /**
     * @var Builder
     */
    protected Builder $builder;

    /**
     * The attributes that can be filtered.
     *
     * @var string[]
     */
    protected array $filterable = [];

    /**
     * The attributes that can be searched.
     *
     * @var string[]
     */
    protected array $searchable = [];

    /**
     * The attributes that can be sorted.
     *
     * @var string[]
     */
    protected array $sortable = [];

    /**
     * Configurations for auto join.
     *
     * @var array
     */
    protected array $joins = [];

    /**
     * Available custom scopes.
     *
     * @var array
     */
    protected array $scopes = [];

    /**
     * Applies filters to the QueryBuilder.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function filter(Builder $builder): Builder
    {
        $this->builder = $builder;

        $this->search();
        $this->sort();
        $this->applyScopes();
        $this->applyFilters();

        return $this->builder;
    }

    /**
     * Applies filters to the QueryBuilder.
     */
    private function applyFilters()
    {
        $filters = request('filters') ?? [];

        foreach ($filters as $configuration) {
            $field = $configuration['field'];
            $operator = $configuration['operator'];
            $value = $configuration['value'];

            if ($this->isFieldFilterable($field) and $this->isValidFilterOperator($operator)) {
                $this->applyFilter($field, $operator, $value);
            } else {
                \Log::warning("Wrong filter params, field - $field, operator - $operator, value - $value");
            }
        }
    }

    /**
     * Apply filter to provided column.
     *
     * @param $field
     * @param $operator
     * @param $value
     */
    private function applyFilter($field, $operator, $value)
    {
        switch ($operator) {
            case 'eq':
                $this->builder->where($field, $value);
                break;
            case 'neq':
                $this->builder->where($field, '!=', $value);
                break;
            case 'gt':
                $this->builder->where($field, '>', $value);
                break;
            case 'gte':
                $this->builder->where($field, '>=', $value);
                break;
            case 'lt':
                $this->builder->where($field, '<', $value);
                break;
            case 'lte':
                $this->builder->where($field, '<=', $value);
                break;
            case 'in':
                $this->builder->whereIn($field, $value);
                break;
            case 'nin':
                $this->builder->whereNotIn($field, $value);
                break;
        }
    }

    /**
     * Check is provided column exists in filterable array.
     *
     * @param string $field
     * @return bool
     */
    private function isFieldFilterable(string $field): bool
    {
        return in_array($field, $this->filterable);
    }

    /**
     * Check is provided filter operator valid.
     *
     * @param $operator
     * @return bool
     */
    private function isValidFilterOperator($operator): bool
    {
        return in_array($operator, $this->getValidFilterOperatorsArray());
    }

    /**
     * Get array of the available filter operators.
     *
     * @return array
     */
    private function getValidFilterOperatorsArray(): array
    {
        return [
            'gt',
            'gte',
            'lt',
            'lte',
            'eq',
            'neq',
            'in',
            'nin'
        ];
    }

    /**
     * Applies joins to the QueryBuilder.
     *
     * @param Builder $builder
     * @param array $tables Tables to join.
     * @return Builder
     */
    public function join(Builder $builder, array $tables): Builder    // TODO: Refactor
    {
        throw_if(count($tables) == 0, new AutoJoinTablesArrayEmptyException());

        $availableConfigurations = array_keys($this->joins);
        $isProvidedUnknownTable = count(array_diff($tables, $availableConfigurations)) > 0;
        throw_if($isProvidedUnknownTable, new AutoJoinUnknownTableException());


        $this->builder = $builder;

        $selectedConfigurations = [];

        foreach ($this->joins as $index => $join) {
            if (in_array($index, $tables)) {
                $selectedConfigurations[] = $join;
            }
        }


        foreach ($selectedConfigurations as $configuration) {
            $this->builder
                ->leftJoin($configuration['table'], $configuration['local'], '=', $configuration['foreign']);
        }

        return $this->builder;
    }


    /**
     * Enables sorting by one of the allowed fields as needed.
     *
     * @return void
     */
    private function sort()    //TODO: Add multiple sorting?
    {
        $sortFieldName = request(self::SORT_BY_PARAMETER_NAME);

        if (array_key_exists($sortFieldName, $this->sortable)) {
            $receivedDirection = Str::lower(request(self::SORT_DIRECTION_PARAMETER_NAME));
            $direction = ($receivedDirection == 'desc') ? 'desc' : 'asc';

            $this->builder->orderBy($this->sortable[$sortFieldName], $direction);
        }
    }

    /**
     * Dynamically apply custom scopes.
     *
     * @throws \Throwable
     */
    private function applyScopes()
    {
        foreach ($this->getScopes() as $scope) {
            $scope = $scope . 'Scope';
            throw_if(!method_exists($this, $scope), new UndefinedFilterScopeException());

            $this->$scope();
        }
    }

    /**
     * Get array of selected and available scopes.
     *
     * @return array
     */
    private function getScopes(): array
    {
        return array_values(array_intersect(request('scopes') ?? [], $this->scopes));
    }

    /**
     * Applies search to the fields listed in the searchable array.
     *
     * @return void
     */
    private function search()
    {
        if (request()->has(self::SEARCH_PARAMETER_NAME))    // Якщо запит хоче виконати пошук
        {
            $searchString = request(self::SEARCH_PARAMETER_NAME);

            $this->builder->where(function ($query) use ($searchString) {
                foreach ($this->searchable as $field) {    // Перебираємо усі поля по яких доступний пошук
                    $query->orWhere($field, 'like', "%$searchString%");
                }
            });
        }
    }

    /**
     * Get perPage parameter for pagination.
     *
     * @return int|null
     */
    public function getPerPage(): ?int
    {
        $requestParam = request(self::PER_PAGE_PARAMETER_NAME);
        return is_numeric($requestParam) ? intval($requestParam) : null;

    }
}
