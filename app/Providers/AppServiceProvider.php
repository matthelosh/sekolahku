<?php

namespace App\Providers;

use PDOException;
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
        // try {
        //     DB::connection()
        //         ->getPdo();
        // } catch ( \Exception $e )
        // {
        //     dd($e);
        //     session()->put('db_error', 'Koneksi Database Error. Cek konfigurasi atau database server');
        //     // dd( $e->getMessage(), $e->getCode() );
        // }
    }
}
