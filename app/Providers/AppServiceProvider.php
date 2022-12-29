<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // INFO: kiírja db comm közben, hogy éppen milyen queryket használ
        // DB::listen(function ($query) {
        //     dump([$query->sql, $query->bindings]);
        // });
    }
}
