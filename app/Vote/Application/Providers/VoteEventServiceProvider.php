<?php

namespace App\Vote\Application\Providers;

use App\Contest\Application\Listeners\VerifyContestHasFinished;
use App\Vote\Application\Events\VoteHasBeenCreated;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class VoteEventServiceProvider extends EventServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(VoteHasBeenCreated::class, VerifyContestHasFinished::class);
    }
}
