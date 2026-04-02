<style>
    .miembro-cuota-indicador { min-width: 76px; max-width: 104px; margin-left: auto; }
    .miembro-cuota-bar { height: 6px; border-radius: 3px; margin: 0 0 3px 0; }
    .miembro-cuota-bar .determinate { transition: width 0.35s ease; }
    .miembro-cuota-txt { font-size: 11px; font-weight: 600; color: #424242; display: block; line-height: 1.1; text-align: center; }
</style>
@foreach ($miembros as $miembro)
    <div class="card-panel blue lighten-5">
        <div class="row">
            <div class="col s12">
                @if ($miembro->esJugadorClub())
                <div class="col s2 right miembro-cuota-indicador">
                    @if (!empty($tempElegida))
                        @php $d = $miembro->datosCuotaInscripcionTemporada($tempElegida); @endphp
                        @if ($d && $d['porcentaje'] !== null)
                            @php
                                $p = $d['porcentaje'];
                                if ($p >= 100) { $colBar = '#1b5e20'; }
                                elseif ($p >= 70) { $colBar = '#388e3c'; }
                                elseif ($p >= 40) { $colBar = '#fb8c00'; }
                                elseif ($p >= 1) { $colBar = '#e65100'; }
                                else { $colBar = '#9e9e9e'; }
                            @endphp
                            <div class="tooltipped" data-tooltip="{{ number_format($d['pagado'], 2, ',', '.') }} € de {{ number_format($d['total'], 2, ',', '.') }} € ({{ $d['porcentaje'] }}%)">
                                <div class="progress miembro-cuota-bar grey lighten-3">
                                    <div class="determinate" style="width: {{ $d['porcentaje'] }}%; background-color: {{ $colBar }};"></div>
                                </div>
                                <span class="miembro-cuota-txt">{{ $d['porcentaje'] }}%</span>
                            </div>
                        @else
                            <span class="grey-text text-lighten-1 tooltipped" data-tooltip="Sin cuota de inscripción calculable">—</span>
                        @endif
                    @else
                        <span class="grey-text text-lighten-1 tooltipped" data-tooltip="Elige una temporada en los criterios">—</span>
                    @endif
                </div>
                @endif

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

                    @if ($miembro->esJugadorClub())
                    <div class="col s1">
                        {{-- <a href="{{route ('crear-pago', [$miembro->id])}}" class="btn-floating black tooltipped" data-tooltip="Pagos"><i class="material-icons">euro_symbol</i></a> --}}
                        <a href="{{ route('pagosMiembro', [$miembro->id]) }}" class="btn-floating black tooltipped" data-tooltip="Pagos"><i class="material-icons">euro_symbol</i></a>
                    </div>
                    @endif

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