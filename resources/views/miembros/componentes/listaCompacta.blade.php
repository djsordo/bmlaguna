<ul class="collapsible popout">
    @foreach ($miembros as $miembro)
        <li>
            <div class="collapsible-header valign-wrapper">
                <div class="col s1 left">
                    @if (is_null($miembro->rutaFoto()))
                        <img src="/images/sinfoto.jpg" class="materialboxed circle z-depth-1" width="50">
                    @else
                        <img src="{{'/docs/'.$miembro->rutaFoto() }}" class="materialboxed circle z-depth-1" width="50">
                    @endif
                </div>

                {{-- <span class="col s1 flow-text red-text center">{{$miembro->dorsal}}</span> --}}

                <div class="col s10 flow-text"><strong>{{ $miembro->nombre . ' ' . $miembro->apellido1 . ' ' . $miembro->apellido2 }}</strong></div>
                
                <div class="col s1">
                    <div class="col s1">
                        @if ($miembro->preinscrito())
                            <i class="material-icons tooltipped md-18" data-tooltip="Preinscrito">euro</i>
                        @else
                            <i class="material-icons tooltipped md-18 md-dark md-inactive" data-tooltip="No Preinscrito">euro</i>
                        @endif
                    </div>

                    <div class="col s1">
                        @if ($miembro->probado())
                            <i class="material-icons tooltipped md-18 " data-tooltip="Equipación Probada">local_grocery_store</i>
                        @else
                            <i class="material-icons tooltipped md-18 md-dark md-inactive" data-tooltip="Equipación No Probada">local_grocery_store</i>
                        @endif
                    </div>

                    <span class="col s12 flow-text red-text center-align">{{$miembro->dorsal}}</span>
                </div>
            </div>

            <div class="collapsible-body">
                <div class="row">
                    <div class="col s1">
                        <a href="/miembros/{{$miembro->id}}" class="btn-floating blue tooltipped" data-tooltip="Ficha del jugador"><i class="material-icons">assignment</i></a>
                    </div>

                    <div class="col s1">
                        <a href="/miembros/{{$miembro->id}}/edit" class="btn-floating green tooltipped" data-tooltip="Editar datos"><i class="material-icons">edit</i></a>
                    </div>

                    <div class="col s1">
                        <a href="/documentosMiembros/{{$miembro->id}}/docsMiembro" class="btn-floating indigo tooltipped" data-tooltip="Documentación"><i class="material-icons">photo_library</i></a>
                    </div>
                    <div class="col s1">
                        <a href="{{route ('crear-pago', [$miembro->id])}}" class="btn-floating black tooltipped" data-tooltip="Pagos"><i class="material-icons">euro_symbol</i></a>
                    </div>

                    <div class="col s1">
                        <a href="/equipacioneMiembroTalla/{{$miembro->id}}/edit" class="btn-floating lime tooltipped" data-tooltip="Equipación"><i class="material-icons">local_grocery_store</i></a>
                    </div>

                    <div class="col s1">
                        <a href="/reconocimientos/{{$miembro->id}}" class="btn-floating yellow tooltipped" data-tooltip="Reconocimientos"><i class="material-icons">local_hospital</i></a>
                    </div>

                    @if (!$miembro->preinscrito())
                        <div class="col s1 right">
                            <a href="{{route ('preins-oficina', [$miembro->id])}}" class="btn-floating orange lighten-2 tooltipped" data-tooltip="Preinscripcion en la oficina"><i class="material-icons">business</i></a>
                            
                        </div>

                        <div class="col s1 right">
                            <a href="{{route ('preinsAntiguos', [$miembro->id])}}" class="btn-floating orange lighten-2 tooltipped" data-tooltip="Enviar Preinscripcion"><i class="material-icons">attach_email</i></a>
                            
                        </div>
                    @endif

                    <div class="col s1 right">
                        <a href="/pdf-equipacion/{{$miembro->id}}" class="btn-floating orange lighten-2 tooltipped" data-tooltip="Imprimir Equipacion"><i class="material-icons">print</i></a>
                    </div> 

                </div>
                <p class="flow-text">Historial</p>
                @for ($i=0; $i < count($miembro->funcionesMiembro()); $i++)
                    <p>@if ($i == 0) <b> @endif {!! $miembro->funcionesMiembro()[$i] !!}@if ($i == 0) </b> @endif</p>
                @endfor
            </div>
        </li>
    @endforeach
</ul>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.materialboxed');
        var instances = M.Materialbox.init(elems);
    });

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.tooltipped');
        var instances = M.Tooltip.init(elems);
    });

    $(document).ready(function(){
        $('.collapsible').collapsible();
    });
</script>