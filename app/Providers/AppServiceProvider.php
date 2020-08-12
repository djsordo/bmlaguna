<?php

namespace BMLaguna\Providers;

use Illuminate\Support\Facades\Schema;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::component('miembros.componentes.contactos', 'contactos');
        Blade::component('miembros.componentes.datosPersonales', 'datosPersonales');
        Blade::component('miembros.componentes.responsables', 'responsables');
        Blade::component('miembros.componentes.ubicacion', 'ubicacion');
        Blade::component('miembros.componentes.lista', 'lista');
        Blade::component('miembros.componentes.listaCompacta', 'listaCompacta');
        Blade::component('miembros.componentes.barraSuperior', 'barraSuperior');
        Blade::component('layouts.barraPrincipal', 'barraPrincipal');
        Blade::component('layouts.paginacion', 'paginacion'); 
        Blade::component('equipaciones.componentes.equipacionMant', 'equipacionMant');
        Blade::component('documentos.componentes.documentoMant', 'documentoMant');
        Blade::component('layouts.menuLateral', 'menuLateral');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
