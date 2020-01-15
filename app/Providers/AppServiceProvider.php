<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        //        /* morphMap for Image model */
        //        Relation::morphMap([
        //            'users' => \App\Models\User::class
        //        ]);
        Blade::component('_layout.components.nestable', 'nestable');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
