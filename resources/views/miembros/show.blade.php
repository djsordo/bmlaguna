@extends('layouts.app')

@section('content')

@include('common.success')

<div class="row">
    <h2 class="center text-flow">FICHA DE MIEMBRO DEL CLUB</h2>

    <div class="card-panel row z-depth-3">
        <div class="col s8">
            @if (!is_null($miembro->f_baja))
                <div class="col s2">
                    <img class="responsive-img" src="/images/baja.jpg">
                </div>
            @else
                <div class="col s2">
                    <h1 class="z-depth-1 red black-text center">{{$miembro->dorsal}}</h1>
                </div>
            @endif

            <div class="card-title col s10">
                <h1 class="center">{{ $miembro->nombre . ' ' . $miembro->apellido1 . ' ' . $miembro->apellido2 }}</h1>
            </div>

            <div class="div col s12">
                <span class="flow-text black-text">Número de socio: {{ $miembro->nSocio }}</span>
            </div>
        </div>

        <div class="card-image center col s3">
            @if (is_null($miembro->rutaFoto()))
                <img src="/images/sinfoto.jpg" class="materialboxed z-depth-2" width="200" >
            @else
                <img src="{{'/docs/'.$miembro->rutaFoto() }}" class="materialboxed z-depth-2" width="200" >
            @endif
        </div>
        <div class="col s1">
            <a href="/miembros/{{$miembro->id}}/edit" class="btn-floating green right"><i class="material-icons">edit</i></a>
        </div>
        <div class="card-content">
            <div class="row">
                <div class="col s12">
                    <ul class="collapsible">
                        <li class="hoverable">
                            <div class="collapsible-header"><h5><i class="material-icons">assignment_ind</i>Funciones</h5></div>
                            <div class="collapsible-body">
                                @for ($i=0; $i < count($miembro->funcionesMiembro()); $i++)
                                    <p class="flow-text"> {!! $miembro->funcionesMiembro()[$i] !!} </p>
                                @endfor
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col s12">
                    <ul class="collapsible">
                        <li class="hoverable">
                            <div class="collapsible-header"><h5><i class="material-icons">person</i>Datos Personales</h5></div>
                            <div class="collapsible-body">
                                <div class="row">
                                
                                    <div class="div col s12 m4 l4">
                                        <label for="nombre">Nombre:</label><br>
                                        <span id="nombre" class="flow-text black-text">{{ $miembro->nombre }}</span>
                                    </div>
                                    <div class="div col s12 m4 l4">
                                        <label for="apellido1">Primer apellido:</label><br>
                                        <span id="apellido1" class="flow-text black-text">{{ $miembro->apellido1 }}</span>
                                    </div>
                                    <div class="div col s12 m4 l4">
                                        <label for="apellido2">Segundo apellido:</label><br>
                                        <span id="apellido2" class="flow-text black-text">{{ (!is_null($miembro->apellido2)) ? $miembro->apellido2 : ' - ' }}</span>
                                    </div>
                                
                                    <div class="div col s12 m4 l4">
                                        <label for="nif">N.I.F. :</label><br>
                                        <span id="nif" class="flow-text black-text">{{ (!is_null($miembro->nif)) ? $miembro->nif : ' - ' }}</span>
                                    </div>
                                    <div class="div col s12 m4 l4">
                                        <label for="f_nacimiento">Fecha de nacimiento:</label><br>
                                        <span id="f_nacimiento" class="flow-text black-text">{{ (!is_null($miembro->f_nacimiento)) ? date('d-m-Y', strtotime($miembro->f_nacimiento) ) : ' - ' }}</span>
                                    </div>
                                    <div class="div col s12 m4 l4">
                                        <label for="sexo">Sexo:</label><br>
                                        <span id="sexo" class="flow-text black-text">{{ (isset($miembro->genero->descripcion)) ? ucfirst($miembro->genero->descripcion) : ' - ' }}</span>
                                    </div>
                                    <div class="div col s12 m4 l4">
                                        <label for="centroEducativo">Centro Educativo:</label><br>
                                        <span id="centroEducativo" class="flow-text black-text">{{ (!is_null($miembro->centroEducativo)) ? $miembro->centroEducativo : ' - ' }}</span>
                                    </div>
                                    <div class="div col s12 m4 l4">
                                        <label for="observaciones">Observaciones:</label><br>
                                        <span id="observaciones" class="flow-text black-text">{{ (!is_null($miembro->observaciones)) ? $miembro->observaciones : ' - ' }}</span>
                                    </div>
                                    <div class="div col s12 m4 l4">
                                        <label for="obserMedicas">Observaciones Medicas:</label><br>
                                        <span id="obserMedicas" class="flow-text black-text">{{ (!is_null($miembro->obserMedicas)) ? $miembro->obserMedicas : ' - ' }}</span>
                                    </div>
                                </div>                                                          
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col s12">
                    <ul class="collapsible">
                        <li class="hoverable">
                            <div class="collapsible-header"><h5><i class="material-icons">place</i>Domicilio</h5></div>
                            <div class="collapsible-body">
                                <div class="row">
                                    <div class="div col s12 m12 l12">
                                        <label for="domicilio">Domicilio:</label><br>
                                        <span id="domicilio" class="flow-text black-text"> {{ $miembro->domicilio }} </span>
                                    </div>
                                    <div class="div col s12 m6 l6">
                                        <label for="localidad">Localidad:</label><br>
                                        <span id="localidad" class="flow-text black-text"> {{ $miembro->localidad }} </span>
                                    </div>
                                    <div class="div col s12 m3 l3">
                                        <label for="provincia">Provincia:</label><br>
                                        <span id="provincia" class="flow-text black-text"> {{ $miembro->provincia }} </span>
                                    </div>
                                
                                    <div class="div col s12 m3 l3">
                                        <label for="c_postal">Código Postal:</label><br>
                                        <span id="c_postal" class="flow-text black-text"> {{ (!is_null($miembro->c_postal)) ? $miembro->c_postal : ' - '}} </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col s12">
                    <ul class="collapsible">
                        <li class="hoverable">
                            <div class="collapsible-header"><h5><i class="material-icons">phone</i><i class="material-icons">email</i>Formas de Contacto</h5></div>
                            <div class="collapsible-body">
                                <div class="row">
                                    <div class="col s12">
                                        @foreach ($miembro->telefonos as $telefono)
                                            <div class="col s12 m6 l6 valign-wrapper">
                                                <span class="col s1"><i class="material-icons">contact_phone</i></span>
                                                <div class="col s11">
                                                    <label for="tel">{{ $telefono->descripcion }}</label><br>
                                                    <span id="tel" class="flow-text black-text"> {{ $telefono->telefono }} </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col s12 divider"></div>
                                    <div class="col s12">
                                        @foreach ($miembro->emails as $email)
                                            <div class="col s12 m6 l6 valign-wrapper">
                                                <span class="col s1"><i class="material-icons">contact_mail</i></span>
                                                <div class="col s11">
                                                    <label for="email">{{ $email->descripcion }}</label><br>
                                                    <span id="email" class="flow-text black-text"> {{ $email->email }} </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col s12">
                    <ul class="collapsible">
                        <li class="hoverable">
                            <div class="collapsible-header"><h5><i class="material-icons">supervisor_account</i>Familiares o Responsables</h5></div>
                            <div class="collapsible-body">
                                <div class="row">
                                    <div class="col s12">
                                        <div class="col s12 m12 l12 valign-wrapper">
                                            <span class="col s1"><i class="material-icons">person</i></span>
                                            <div class="col s11">
                                                <span id="resp1" class="flow-text black-text"> <a href="/miembros/{{$resp1->id}}">{{ $resp1->nombre . ' ' . $resp1->apellido1 . ' ' . $resp1->apellido2 }}</a> </span>
                                            </div>
                                        </div>
                                        <div class="col s12 m12 l12 valign-wrapper">
                                            <span class="col s1"><i class="material-icons">person</i></span>
                                            <div class="col s11">
                                                <span id="resp2" class="flow-text black-text"> <a href="/miembros/{{$resp2->id}}">{{ $resp2->nombre . ' ' . $resp2->apellido1 . ' ' . $resp2->apellido2 }}</a> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col s12">
                    <ul class="collapsible">
                        <li class="hoverable">
                            <div class="collapsible-header"><h5><i class="material-icons">local_grocery_store</i>Equipación</h5></div>
                                <div class="collapsible-body">
                                    <div class="row">
                                        <div class="col s12">
                                            <table class="centered">
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        
                                                            @foreach ($equipaciones as $equipacion)
                                                            <td>
                                                                @if (is_null($equipacion->rutaImagen))
                                                                    <img width="40px" src="/images/sinfoto.jpg" id="foto" alt="">                                  
                                                                @else
                                                                    <img width="40px" src="{{'/images/'.$equipacion->rutaImagen}}" id="foto" alt="">
                                                                @endif
                                                            </td>
                                                            @endforeach
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Talla</strong></td>
                                                        
                                                            @foreach ($equipaciones as $equipacion)
                                                            <td>
                                                                @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                                                    {{BMLaguna\Talla::find($equipacionesMiembro->find($equipacion->id)->pivot->talla_id)->descripcion}}
                                                                @endif
                                                            </td>
                                                            @endforeach
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Fecha de Prueba</strong></td>
                                                        
                                                            @foreach ($equipaciones as $equipacion)
                                                            <td>
                                                                @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                                                    @if (!is_null($equipacionesMiembro->find($equipacion->id)->pivot->f_prueba))
                                                                        {{date('d-m-Y', strtotime($equipacionesMiembro->find($equipacion->id)->pivot->f_prueba))}}
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            @endforeach
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Fecha de Pedido</strong></td>
                                                        
                                                            @foreach ($equipaciones as $equipacion)
                                                            <td>
                                                                @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                                                    @if (!is_null($equipacionesMiembro->find($equipacion->id)->pivot->f_pedido))
                                                                        {{date('d-m-Y', strtotime($equipacionesMiembro->find($equipacion->id)->pivot->f_pedido))}}
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            @endforeach
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Fecha de Llegada</strong></td>
                                                        
                                                            @foreach ($equipaciones as $equipacion)
                                                            <td>
                                                                @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                                                    @if (!is_null($equipacionesMiembro->find($equipacion->id)->pivot->f_llegada))
                                                                        {{date('d-m-Y', strtotime($equipacionesMiembro->find($equipacion->id)->pivot->f_llegada))}}
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            @endforeach
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Fecha de Envío a serigrafía</strong></td>
                                                        
                                                            @foreach ($equipaciones as $equipacion)
                                                            <td>
                                                                @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                                                    @if (!is_null($equipacionesMiembro->find($equipacion->id)->pivot->f_envioseri))
                                                                        {{date('d-m-Y', strtotime($equipacionesMiembro->find($equipacion->id)->pivot->f_envioseri))}}
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            @endforeach
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Fecha de llegada de serigrafía</strong></td>
                                                        
                                                            @foreach ($equipaciones as $equipacion)
                                                            <td>
                                                                @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                                                    @if (!is_null($equipacionesMiembro->find($equipacion->id)->pivot->f_llegadaseri))
                                                                        {{date('d-m-Y', strtotime($equipacionesMiembro->find($equipacion->id)->pivot->f_llegadaseri))}}
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            @endforeach
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Fecha de Entrega</strong></td>
                                                        @foreach ($equipaciones as $equipacion)
                                                        <td>
                                                            @if (!is_null($equipacionesMiembro->find($equipacion->id)))
                                                                @if (!is_null($equipacionesMiembro->find($equipacion->id)->pivot->f_entrega))
                                                                    {{date('d-m-Y', strtotime($equipacionesMiembro->find($equipacion->id)->pivot->f_entrega))}}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        @endforeach
                                                    </tr>
            
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.collapsible');
        var instances = M.Collapsible.init(elems);
    });

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.materialboxed');
        var instances = M.Materialbox.init(elems);
    });
</script>
@endsection