<?php

namespace App\Invoice\Application\Providers;

use App\Invoice\Domain\InvoiceRepository;
use App\Invoice\Infrastructure\Http\Alegra\InvoiceRepository as AlegraInvoiceRepository;
use Illuminate\Support\ServiceProvider;

class InvoiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(InvoiceRepository::class, AlegraInvoiceRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
