<?php

namespace App\Models;

use App\Filters\InvoiceFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property string $number
 * @property string $date
 * @property int $provider_id
 * @property int $receiver_id
 * @property string|null $file_url
 * @property float|null $total_sum
 * @property bool $approved
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|Item[] $items
 * @property-read int|null $items_count
 * @property-read Collection|License[] $licenses
 * @property-read int|null $licenses_count
 * @property-read Provider $provider
 * @property-read User $receiver
 * @mixin Eloquent
 */
class Invoice extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'approved' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'number',
        'provider_id',
        'receiver_id',
        'file_url',
        'total_sum',
        'approved'
    ];

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return InvoiceFilter::class;
    }

    /**
     * Invoice licenses, one-to-many relations.
     *
     * @return HasMany
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    /**
     * Invoice items, one-to-many relations.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Invoice provider, one-to-many relations.
     *
     * @return BelongsTo
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Invoice receiver, one-to-many relations.
     *
     * @return BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
