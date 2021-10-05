<?php

namespace App\Seller\Application\Providers;

use App\Seller\Application\Events\SellerHasBeenCreated;
use App\Seller\Application\Listeners\SyncCreatedSellerWithAlegra;
use App\Shared\Application\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Event;

class SellerEventServiceProvider extends EventServiceProvider
{
    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(SellerHasBeenCreated::class, SyncCreatedSellerWithAlegra::class);
    }
}
