<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Profil;
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
        // Mengambil data profil
        $profil = Profil::first();

        // Membagikan data profil ke seluruh view
        View::share('profil', $profil);
    }
}
