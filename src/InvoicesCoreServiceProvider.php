<?php

namespace Invoices\Core;

use Illuminate\Support\ServiceProvider;

class InvoicesCoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {        
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    
    }
}