<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Préchargement des images pour la page d'accueil
        $this->app['view']->composer('welcome', function ($view) {
            $view->with('preconnect', true);
        });
    }
}
