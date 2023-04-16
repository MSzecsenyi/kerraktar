<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\Paginator;
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
        Paginator::defaultView('vendor/pagination/paginator');
        // INFO: kiírja db comm közben, hogy éppen milyen queryket használ
        // DB::listen(function ($query) {
        //     dump([$query->sql, $query->bindings]);
        // });
    }
}
