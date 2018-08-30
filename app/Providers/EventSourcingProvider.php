<?php

namespace App\Providers;

use App\EventSourcing\Repository\AccountRepository;
use Illuminate\Support\ServiceProvider;

class EventSourcingProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AccountRepository::class, function ($app) {
            $eventStore = $app[\Broadway\EventStore\EventStore::class];
            $eventBus = $app[\Broadway\EventHandling\EventBus::class];
            return new AccountRepository($eventStore, $eventBus);
        });
    }
}
