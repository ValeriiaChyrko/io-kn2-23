<?php

namespace App\Models;

use App\Filters\LicenseFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\License
 *
 * @property int $id
 * @property int $software_model_id
 * @property string|null $price
 * @property int|null $item_id
 * @property int $invoice_id
 * @property int $owner_id
 * @property Carbon|null $end_date
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Invoice $invoice
 * @property-read Item|null $item
 * @property-read User $owner
 * @property-read SoftwareModel $softwareModel
 * @mixin Eloquent
 */
class License extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'end_date' => 'date'
    ];

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return LicenseFilter::class;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'software_model_id',
        'price',
        'item_id',
        'invoice_id',
        'owner_id',
        'end_date'
    ];

    /**
     * License item, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * License invoice, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * License owner, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    /**
     * License software model, one-to-many relations.
     *
     * @return BelongsTo
     */
    public function softwareModel(): BelongsTo
    {
        return $this->belongsTo(SoftwareModel::class);
    }
}
