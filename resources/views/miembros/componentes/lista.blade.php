@foreach ($miembros as $miembro)
    <div class="card-panel blue lighten-5">
        <div class="row">
            <div class="col s12">
                <div class="col s1 right">
                    @if ($miembro->preinscrito())
                        <i class="material-icons tooltipped" data-tooltip="Preinscrito">euro_symbol</i>
                    @endif
                </div>

                <div class="col s1 right">
                    @if ($miembro->probado())
                        <i class="material-icons tooltipped" data-tooltip="Equipación Probada">local_grocery_store</i>
                    @endif
                </div>

            </div>
            <div class="card-image col s3">
                @if (is_null($miembro->rutaFoto()))
                    <img src="/images/sinfoto.jpg" class="materialboxed z-depth-2" width="80" >
                @else
                    <img src="{{'/docs/'.$miembro->rutaFoto() }}" class="materialboxed z-depth-2" width="80">
                @endif
            </div>

            <div class="card-content col s7">
                <p class="flow-text"><strong>{{ $miembro->nombre . ' ' . $miembro->apellido1 . ' ' . $miembro->apellido2 }}</strong></p>
                @for ($i=0; $i < count($miembro->funcionesMiembro()); $i++)
                    <p > {!! $miembro->funcionesMiembro()[$i] !!} </p>
                @endfor
            </div>

            <div class="card-content col s2">
                <h1 class="red-text right">{{ $miembro->dorsal }}</h1>
            </div>

            <div class="card-action col s12">
                <br>
                <div class="divider"></div>
                <br>
                <div class="row">
                    <div class="col s1">
                        <a href="/documentosMiembros/{{$miembro->id}}/docsMiembro" class="btn-floating indigo tooltipped" data-tooltip="Documentación"><i class="material-icons">photo_library</i></a>
                    </div>

                    <div class="col s1">
                        <a href="/miembros/{{$miembro->id}}" class="btn-floating blue tooltipped" data-tooltip="Ficha del jugador"><i class="material-icons">assignment</i></a>
                    </div>

                    <div class="col s1">
                        <a href="/miembros/{{$miembro->id}}/edit" class="btn-floating green tooltipped" data-tooltip="Editar datos"><i class="material-icons">edit</i></a>
                    </div>

                    <div class="col s1">
                        <!-- <a href="{{route ('miembroPagos', [$miembro->id])}}" class="btn-floating black tooltipped" data-tooltip="Pagos"><i class="material-icons">euro_symbol</i></a> -->

                        <a href="/pagosMiembro/{{$miembro->id}}" class="btn-floating black tooltipped" data-tooltip="Pagos"><i class="material-icons">euro_symbol</i></a>
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
                            <a href="{{route ('preinsAntiguos', [$miembro->id])}}" class="btn-floating orange lighten-2 tooltipped" data-tooltip="Enviar Preinscripcion"><i class="material-icons">local_post_office</i></a>

                        </div>
                    @endif

                    <div class="col s1 right">
                        <a href="/pdf-equipacion/{{$miembro->id}}" class="btn-floating orange lighten-2 tooltipped" data-tooltip="Imprimir Equipacion"><i class="material-icons">print</i></a>
                    </div>

                    {{-- <div class="col s7">
                        <form action="/miembros/{{$miembro->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-floating red right"><i class="material-icons">delete</i></button>
                        </form>
                    </div>
                    --}}
                </div>
            </div>
        </div>
    </div>
@endforeach
{{-- {!! $miembros->links() !!} --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.materialboxed');
        var instances = M.Materialbox.init(elems);
    });

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.tooltipped');
        var instances = M.Tooltip.init(elems);
    });
</script>
