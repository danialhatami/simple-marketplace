<?php

namespace Danial\SimpleMarketplace\Providers;

use Danial\SimpleMarketplace\Console\Commands\InstallCommand;
use Danial\SimpleMarketplace\Events\OrderCreated;
use Danial\SimpleMarketplace\Exceptions\CustomExceptionHandler;
use Danial\SimpleMarketplace\Http\Middlewares\MustBeLoggedIn;
use Danial\SimpleMarketplace\Listeners\SendOrderNotification;
use Danial\SimpleMarketplace\Models\Order;
use Danial\SimpleMarketplace\Models\Product;
use Danial\SimpleMarketplace\Policies\OrderPolicy;
use Danial\SimpleMarketplace\Policies\ProductPolicy;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\SanctumServiceProvider;

class SimpleMarketplaceServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        Route::middlewareGroup('bindings', [
            SubstituteBindings::class,
        ]);

        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }

        \Illuminate\Support\Facades\Event::listen(
            OrderCreated::class,
            SendOrderNotification::class
        );

        AboutCommand::add('Simple Marketplace', fn () => [
            'Version' => '0.0.1',
            'Published By' => 'Danial Hatami'
        ]);
    }

    public function register(): void
    {
        $this->app->singleton(
            ExceptionHandler::class,
            CustomExceptionHandler::class
        );
        $this->app->register(SanctumServiceProvider::class);
    }
}
