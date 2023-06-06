<?php

namespace App\Providers;

use App\Models\Item;
use App\Models\License;
use App\Models\Repair;
use App\Observers\ItemObserver;
use App\Observers\LicenseObserver;
use App\Observers\RepairObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Item::observe(ItemObserver::class);
        License::observe(LicenseObserver::class);
        Repair::observe(RepairObserver::class);
    }
}
