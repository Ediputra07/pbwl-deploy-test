<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
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
        // Mode ketat: error jika ada mass assignment yang dibuang
        Model::preventSilentlyDiscardingAttributes(! app()->isProduction());

        // Dari Modul 2: error jika terjadi lazy loading (N+1)
        Model::preventLazyLoading(! app()->isProduction());

        Paginator::useBootstrapFive();

        Gate::define('kelola-mata-kuliah', function (User $user) {
            return $user->hasAnyRole(['admin', 'dosen']);
        });
    }
}
