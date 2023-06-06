<?php

namespace App\Stats;

use App\Exceptions\UnknownStatsGroupByKeyException;
use App\Exceptions\UnknownStatsJoinedTitleKeyException;

class ItemStats
{
    /**
     * Array of available columns for group_by for items stats request.
     *
     * @var array|string[]
     */
    protected static array $groupBy = [
        'type' => 'items.type_id',
        'hardware_model' => 'items.hardware_model_id',
        'department' => 'items.department_id',
        'owner' => 'items.owner_id'
    ];

    /**
     * Array of available columns for group_by for items stats request.
     *
     * @var array|string[]
     */
    protected static array $joinedTitle = [
        'type' => 'types.title',
        'hardware_model' => 'hardware_models.title',
        'department' => 'departments.title',
        'owner' => 'owner.name'
    ];

    /**
     * Get array of available group_by keys.
     *
     * @return array Available keys
     */
    public static function getAvailableGroupBy(): array {
       return array_keys(static::$groupBy);
    }

    /**
     * Get column for group_by in item stats request.
     *
     * @param string $key Key from $groupBy array record
     * @return string Column in database
     * @throws UnknownStatsGroupByKeyException
     */
    public static function getColumnByKey(string $key): string
    {
        if(!array_key_exists($key, static::$groupBy)) throw new UnknownStatsGroupByKeyException();

        return static::$groupBy[$key];
    }

    /**
     * Get joined_title for select in item stats request.
     *
     * @param string $key Key from $joinedTitle array record
     * @return string Column for select
     * @throws UnknownStatsJoinedTitleKeyException
     */
    public static function getJoinedByKey(string $key): string
    {
        if(!array_key_exists($key, static::$joinedTitle)) throw new UnknownStatsJoinedTitleKeyException();

        return static::$joinedTitle[$key];
    }
}
