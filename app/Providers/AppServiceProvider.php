<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

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
        LogViewer::auth(function ($request) {
            return $request->user() && $request->user()->is_admin;
        });
        // INFO: kiírja db comm közben, hogy éppen milyen queryket használ
        // DB::listen(function ($query) {
        //     dump([$query->sql, $query->bindings]);
        // });
    }
}
