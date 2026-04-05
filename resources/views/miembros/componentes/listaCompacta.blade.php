<style>
    .miembro-cuota-indicador { min-width: 76px; max-width: 104px; margin-left: auto; }
    .miembro-cuota-bar { height: 6px; border-radius: 3px; margin: 0 0 3px 0; }
    .miembro-cuota-bar .determinate { transition: width 0.35s ease; }
    .miembro-cuota-txt { font-size: 11px; font-weight: 600; color: #424242; display: block; line-height: 1.1; text-align: center; }
</style>
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

                <div class="col s9 m10 flow-text"><strong>{{ $miembro->nombre . ' ' . $miembro->apellido1 . ' ' . $miembro->apellido2 }}</strong></div>
                
                <div class="col s2 m1">
                    @if ($miembro->esJugadorClub())
                    <div class="col s12 miembro-cuota-indicador">
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
                                <span class="grey-text text-lighten-1 tooltipped" data-tooltip="Sin cuota de inscripción calculable para esta temporada">—</span>
                            @endif
                        @else
                            <span class="grey-text text-lighten-1 tooltipped" data-tooltip="Elige una temporada en los criterios de búsqueda">—</span>
                        @endif
                    </div>
                    @endif

                    <div class="col s12 center-align" style="margin-top:4px;">
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
                    @if ($miembro->esJugadorClub())
                    <div class="col s1">
                        {{-- <a href="{{route ('crear-pago', [$miembro->id])}}" class="btn-floating black tooltipped" data-tooltip="Pagos"><i class="material-icons">euro_symbol</i></a> --}}
                        <a href="{{route ('pagosMiembro', [$miembro->id])}}" class="btn-floating black tooltipped" data-tooltip="Pagos"><i class="material-icons">euro_symbol</i></a>
                    </div>
                    @endif

                    <div class="col s1">
                        <a href="/equipacioneMiembroTalla/{{$miembro->id}}/edit" class="btn-floating lime tooltipped" data-tooltip="Equipación"><i class="material-icons">local_grocery_store</i></a>
                    </div>

                    <div class="col s1">
                        <a href="/reconocimientos/{{$miembro->id}}" class="btn-floating yellow tooltipped" data-tooltip="Reconocimientos"><i class="material-icons">local_hospital</i></a>
                    </div>

                    @if ($miembro->esJugadorClub())
                    <div class="col s1">
                        <a href="{{ route('informesFtt', $miembro->id) }}" class="btn-floating deep-purple lighten-1 tooltipped" data-tooltip="Informe físico-técnico-táctico"><i class="material-icons">assessment</i></a>
                    </div>
                    @endif

                    @php
                        $waUrl = whatsapp_wa_me_url(optional($miembro->telefonos->first())->telefono, 'Estoy probando una pequeña automatización de Whatsapp');
                    @endphp
                    <div class="col s1">
                        @if ($waUrl)
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="btn-floating teal tooltipped" data-tooltip="WhatsApp (demo)"><i class="material-icons">chat</i></a>
                        @else
                            <span class="btn-floating grey lighten-2 tooltipped" style="cursor:default; pointer-events:auto;" data-tooltip="Sin teléfono válido para WhatsApp"><i class="material-icons grey-text text-lighten-1">chat</i></span>
                        @endif
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

                    <div class="col s12">
                        <p class="flow-text">Historial</p>
                        @for ($i=0; $i < count($miembro->funcionesMiembro()); $i++)
                            <p>@if ($i == 0) <b> @endif {!! $miembro->funcionesMiembro()[$i] !!}@if ($i == 0) </b> @endif</p>
                        @endfor
                    </div>
                    <div class="col s12 right-align">
                        @if (!is_null($miembro->f_baja))
                            <a href="{{route ('miembroActivar', $miembro)}}" class="black-text tooltipped" data-tooltip="Reactivar miembro"><i class="material-icons">published_with_changes</i></a>
                        @else 
                            <a href="{{route ('miembroBaja', $miembro)}}" class="black-text tooltipped" data-tooltip="Dar de baja miembro"><i class="material-icons">unpublished</i></a>
                        @endif
                    </div>
                </div>
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