<?php

namespace App\Providers;

use App\Supports\Enums\RoleEnum;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        //Acceso por roles para modulo Mi equipo
        Gate::define('mi_equipo', function ($user) {
            return $user->hasAnyRole([
                    RoleEnum::SISTEMAS->value,
                    RoleEnum::ENCARGADO->value,
                    RoleEnum::JEFE_EQUIPO->value
                ]);
        });

        //Acceso por roles para modulo Reportes
        Gate::define('reportes', function ($user) {
            return $user->hasAnyRole([
                    RoleEnum::SISTEMAS->value,
                    RoleEnum::ENCARGADO->value,
                    RoleEnum::JEFE_EQUIPO->value
                ]);
        });

        //Acceso por roles para modulo Archivo
        Gate::define('archivo', function ($user) {
            return $user->hasAnyRole([
                    RoleEnum::SISTEMAS->value,
                    RoleEnum::ENCARGADO->value,
                    RoleEnum::JEFE_EQUIPO->value
                ]);
        });

        //Acceso por roles para modulo Mi trabajo diario
        Gate::define('mi_trabajo_diario', function ($user) {
            return $user->hasAnyRole([
                    RoleEnum::SISTEMAS->value,
                    RoleEnum::ENCARGADO->value,
                    RoleEnum::JEFE_EQUIPO->value
                ]);
        });

        //Acceso por roles para Asignacion
        Gate::define('asignar', function ($user) {
            return $user->hasAnyRole([
                    RoleEnum::SISTEMAS->value,
                    RoleEnum::JEFE_EQUIPO->value
                ]);
        });

        //Acceso por roles para ReAsignacion
        Gate::define('reasignar', function ($user) {
            return $user->hasAnyRole([
                    RoleEnum::SISTEMAS->value,
                    RoleEnum::JEFE_EQUIPO->value
                ]);
        });

        Paginator::useBootstrapFive(); 
    }
    
}
