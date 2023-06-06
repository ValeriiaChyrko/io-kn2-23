<?php

namespace App\Models;

use App\Filters\UserFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\User
 *
 * @property int $id Record id.
 * @property string $name User full name.
 * @property string|null $google_id User google account id.
 * @property string $email User email.
 * @property string|null $password User password.
 * @property Role $role User role.
 * @property Role $role_id User role id.
 * @property string|null $avatar Avatar url.
 * @property string|null $remember_token Login remember token.
 * @property Carbon|null $created_at Timestamp when record was created.
 * @property Carbon|null $updated_at Timestamp when record was updated.
 * @property Carbon|null $deleted_at Timestamp when record was soft-deleted.
 * @property-read bool $is_deletable Indicates is user can be deleted.
 * @property-read string[] $permissions Array of user permissions
 * @property-read Collection|Item[] $items Collection of user items, one-to-many relations.
 * @property-read int|null $items_count User items count.
 * @property-read Collection|License[] $licenses Collection of user licenses, one-to-many relations.
 * @property-read int|null $licenses_count User licenses count.
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Transfer[] $receivedTransfers Collection of transfers received by user, one-to-many relations.
 * @property-read int|null $received_transfers_count Received user transfers count.
 * @property-read Collection|Repair[] $repairs Collection of user repairs, one-to-many relations.
 * @property-read int|null $repairs_count User repairs count.
 * @property-read Collection|Transfer[] $sentTransfers Collection of transfers sent by user, one-to-many relations.
 * @property-read int|null $sent_transfers_count Sent user transfers count.
 * @property-read Collection|Invoice[] $receivedInvoices Invoices received by user, one-to-many relations.
 * @property-read int|null $received_invoices_count Sent user transfers count.
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, Filterable, SoftDeletes;

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
        'name', 'email', 'password', 'role_id', 'google_id', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Accessor for is_deletable attribute.
     * Indicate is user can be deleted.
     *
     * @return bool
     */
    public function getIsDeletableAttribute(): bool    // TODO: Check writeoffs and utilization count
    {
        return $this->items_count == 0
            and $this->licenses_count == 0
            and $this->sent_transfers_count == 0
            and $this->received_transfers_count == 0
            and $this->repairs_count == 0;
    }

    /**
     * Accessor for permissions attribute.
     * Returns array of user permissions.
     *
     * @return array
     */
    public function getPermissionsAttribute(): array
    {
        if(empty($this->role)) {
            return [];
        }

        return $this->role->permissions->map(function($permission) {
            return $permission->name;
        })->toArray();
    }

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return UserFilter::class;
    }

    /**
     * User role, many-to-one relations.
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * User licenses, one-to-many relations.
     *
     * @return HasMany
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(License::class, 'owner_id', 'id');
    }

    /**
     * User items, one-to-many relations.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'owner_id', 'id');
    }

    /**
     * User repairs, one-to-many relations.
     *
     * @return HasMany
     */
    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }

    /**
     * Transfers sent by user, user transfers, one-to-many relations.
     *
     * @return HasMany
     */
    public function sentTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'from_user_id', 'id');
    }

    /**
     * Transfers received by user, user transfers, one-to-many relations.
     *
     * @return HasMany
     */
    public function receivedTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'to_user_id', 'id');
    }

    /**
     * Invoices received by user, one-to-many relations.
     *
     * @return HasMany
     */
    public function receivedInvoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'receiver_id', 'id');
    }
}
