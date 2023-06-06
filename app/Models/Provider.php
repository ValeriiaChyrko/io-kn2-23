<?php

namespace App\Models;

use App\Filters\ProviderFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Provider
 *
 * @property int $id Record id.
 * @property string $title Provider title.
 * @property string|null $address Provider address.
 * @property string|null $phone Provider phone number.
 * @property Carbon|null $created_at Timestamp when record was created.
 * @property Carbon|null $updated_at Timestamp when record was updated.
 * @property Carbon|null $deleted_at Timestamp when record was soft-deleted.
 * @property-read bool $is_deletable Indicates is provider can be deleted.
 * @property-read Collection|Invoice[] $invoices Collection of provider invoices, one-to-many relations.
 * @property-read int|null $invoices_count Provider invoices count.
 * @property-read Collection|Repair[] $repairs Collection of provider repairs, one-to-many relations.
 * @property-read int|null $repairs_count Provider repairs count.
 * @mixin Eloquent
 */
class Provider extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'address',
        'phone',
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
     * Accessor for is_deletable attribute.
     * Indicates is provider can be deleted.
     *
     * @return bool
     * @throws \Exception
     */
    public function getIsDeletableAttribute(): bool    // TODO: Check utilization count
    {
        /*
        if(is_null($this->repairs_count) or is_null($this->invoices_count)) {
            throw new \Exception();    //TODO
        }
        */

        return $this->repairs_count == 0 and $this->invoices_count == 0;
    }

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return ProviderFilter::class;
    }

    /**
     * Provider invoices, one-to-many relations.
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Provider repairs, one-to-many relations.
     *
     * @return HasMany
     */
    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }
}
