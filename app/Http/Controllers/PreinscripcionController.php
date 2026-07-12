<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use BMLaguna\Preinscripcion;
use BMLaguna\Genero;
use BMLaguna\Miembro;
use BMLaguna\Telefono;
use BMLaguna\Email;
use BMLaguna\Pago;
use BMLaguna\Tipospago;
use BMLaguna\Categoria;

use BMLaguna\Temporada;
use BMLaguna\Contador_recibo;

use Mail;
use Session;
use Redirect;
use Barryvdh\DomPDF\Facade as PDF;
use JavaScript;


class PreinscripcionController extends Controller
{
    const PREINS_SESSION_MIEMBRO = 'preins_public_miembro_id';
    const PREINS_SESSION_OK_AT = 'preins_public_ok_at';
    const PREINS_SESSION_HOURS = 4;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Request $request)
    {
        // Sacamos el tipo de listado que queremos
        if (!is_null($request->input('tipo'))){
            $tipoListado = $request->input('tipo');
        }
        else{
            $tipoListado = 'Todas';
        }

        // Lista de temporadas
        $temporadas = Temporada::all();
        if ($request->get('temporada_id') == '') {
            $tempActual_id = Temporada::actual()->id;
        }
        else{
            $tempActual_id = $request->get('temporada_id');
        }

        $tempActual = Temporada::Tactual();
        $tempElegida = Temporada::find($tempActual_id);

        // Lista de Categorías
        $categorias = Categoria::all()->sortBy('orden');
        if ($request->get('categoria_id') == '') {
            $catActual_id = null;
        }
        else{
            $catActual_id = $request->get('categoria_id');
        }
        $catElegida = Categoria::find($catActual_id);

        // Lista de géneros
        $generos = Genero::all();
        if ($request->get('genero_id') == '') {
            $genActual_id = null;
        }
        else{
            $genActual_id = $request->get('genero_id');
        }
        $genElegido = Genero::find($genActual_id);

        // Búsqueda por nombre
        $textoBusqueda = $request->input('nombre');

        // Totales
        $total['Pendientes'] =  Preinscripcion::where('temporada_id', $tempActual_id)->
                                    where('estado', 'Pendiente de Pago')->count();
        $total['Pagadas'] =     Preinscripcion::where('temporada_id', $tempActual_id)->
                                    where('estado', 'Pagado')->count();
        $total['Todas'] =       Preinscripcion::where('temporada_id', $tempActual_id)->count();

        // Estado de la preinscripcion
        if ($tipoListado == 'Pendientes') {
            $estado = 'Pendiente de Pago';
        }
        elseif ($tipoListado == 'Pagadas') {
            $estado = 'Pagado';
        }
        else {
            $estado = null;
        }

        // Query de Búsqueda con criterios
        $preinscripcionesQuery = Preinscripcion::where('temporada_id', $tempActual_id)->
            orderBy('nPreinscripcion');

        if (!is_null($textoBusqueda)){
            $preinscripcionesQuery = $preinscripcionesQuery->where(DB::raw("concat(nombre, ' ', apellido1, ' ', IFNULL(apellido2, ' '))"), "like",  "%$textoBusqueda%");
        }

        if (!is_null($genActual_id)){
            $preinscripcionesQuery = $preinscripcionesQuery->where('genero_id', $genActual_id);
        }

        if (!is_null($estado)){
            $preinscripcionesQuery = $preinscripcionesQuery->where('estado', $estado);
        }

        if (!is_null($catActual_id)){
            $preinscripcionesQuery = $preinscripcionesQuery->whereYear('f_nacimiento','>=', $catElegida->rangoAnnos($tempElegida)[0])->
                whereYear('f_nacimiento','<=', $catElegida->rangoAnnos($tempElegida)[1]);

        }
        //----------------------------------------------------------

       /*  $preinscripcionesNP = $totalPreinscripciones->get(); */
        $preinscripciones = $preinscripcionesQuery->paginate(10);

        $path = $request->url().'?temporada_id='.$tempActual_id.'&tipo='.$tipoListado.'&nombre='.$textoBusqueda. '&categoria_id='.$catActual_id. '&genero_id='.$genActual_id;

        return view('preinscripciones.index', compact('preinscripciones', 'total', 'categorias', 'catActual_id', 'generos', 'genActual_id', 'temporadas', 'tempElegida', 'tempActual_id', 'tipoListado', 'path', 'textoBusqueda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $miembro_id = 0)
    {
        return $this->buildCreateFormView($miembro_id, null);
    }

    /**
     * Formulario público de preinscripción (enlace firmado del correo).
     */
    public function createPublic($miembro_id)
    {
        $miembro = Miembro::find($miembro_id);
        if (is_null($miembro)) {
            abort(404);
        }

        $temporada = Temporada::actual();
        if (is_null($temporada)) {
            abort(503, 'No hay temporada de preinscripción activa.');
        }

        $preExiste = Preinscripcion::where('miembro_id', $miembro_id)
            ->where('temporada_id', $temporada->id)
            ->first();
        if (! is_null($preExiste)) {
            return view('preinscripciones.existe', compact('preExiste'));
        }

        session([
            self::PREINS_SESSION_MIEMBRO => (int) $miembro_id,
            self::PREINS_SESSION_OK_AT => now()->toDateTimeString(),
        ]);

        return $this->buildCreateFormView($miembro_id, true);
    }

    private function buildCreateFormView($miembro_id, $quitaBarra)
    {
        $generos = Genero::where('descripcion', '!=', 'mixto')->get();
        $temporada = Temporada::actual();
        $miembro = Miembro::find($miembro_id);
        if (! is_null($miembro)) {
            $resp1 = Miembro::find($miembro->responsable1_id);
            $resp2 = Miembro::find($miembro->responsable2_id);
        } else {
            $resp1 = null;
            $resp2 = null;
        }
        $telefono = Telefono::where('miembro_id', $miembro_id)->first();
        $email = Email::where('miembro_id', $miembro_id)->first();
        $dorsales = range(1, 99);

        return view('preinscripciones.create', compact(
            'generos', 'temporada', 'miembro', 'resp1', 'resp2', 'telefono', 'email', 'quitaBarra', 'dorsales'
        ));
    }

    private function preinscripcionDuplicadaEnTemporadaActual($miembro_id)
    {
        $temporada = Temporada::actual();
        if (is_null($temporada) || empty($miembro_id)) {
            return null;
        }

        return Preinscripcion::where('miembro_id', $miembro_id)
            ->where('temporada_id', $temporada->id)
            ->first();
    }

    private function esMayorDeEdad(?string $fNacimiento): bool
    {
        if (empty($fNacimiento)) {
            return false;
        }

        return Carbon::parse($fNacimiento)->age >= 18;
    }

    private function validarPreinscripcion(Request $request): void
    {
        $mayor = $this->esMayorDeEdad($request->input('f_nacimiento'));

        $request->validate([
            'f_nacimiento' => 'required|date',
            'modalidad_cuotas' => 'required|integer|in:1,2,3',
            'centroEducativo' => $mayor ? 'nullable|string|max:255' : 'required|string|max:255',
            'nombreR1' => $mayor ? 'nullable|string|max:255' : 'required|string|max:255',
            'apellido1R1' => $mayor ? 'nullable|string|max:255' : 'required|string|max:255',
        ], [
            'centroEducativo.required' => 'El centro educativo es obligatorio para menores de 18 años.',
            'nombreR1.required' => 'El nombre del padre/madre o tutor es obligatorio para menores de 18 años.',
            'apellido1R1.required' => 'El primer apellido del padre/madre o tutor es obligatorio para menores de 18 años.',
        ]);
    }

    private function normalizarCampoOpcional($value): ?string
    {
        if (! is_string($value)) {
            return is_null($value) ? null : (string) $value;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }

    private function aplicarModalidadCuota(Preinscripcion $preinscripcion, Request $request)
    {
        $modalidad = (int) $request->input('modalidad_cuotas');
        $preinscripcion->modalidad_cuotas = $modalidad;
        $preinscripcion->importePago = $preinscripcion->importePrimerPlazo($modalidad);

        return $preinscripcion->importePago;
    }

    private function ensureMiembroParaPagos(Preinscripcion $preinscripcion)
    {
        if (is_null($preinscripcion->miembro_id)) {
            $miembro = Miembro::nuevo($preinscripcion);
            $preinscripcion->miembro_id = $miembro->id;
            $preinscripcion->save();
        } else {
            $miembro = Miembro::find($preinscripcion->miembro_id);
            if ($miembro) {
                $miembro->asegurarFuncionClubJugadorEnFicha();
            }
        }
    }

    private function queryPagosPreinscripcion(Preinscripcion $preinscripcion)
    {
        $query = Pago::where('miembro_id', $preinscripcion->miembro_id)
            ->where('temporada_id', $preinscripcion->temporada_id);

        if ($preinscripcion->modalidad_cuotas) {
            $tipospagoIds = Tipospago::tiposPorModalidad($preinscripcion->modalidad_cuotas)->pluck('id');
            $query->whereIn('tipospago_id', $tipospagoIds);
        } else {
            $legacyId = Tipospago::where('descripcion', 'Preinscripción')->value('id');
            if ($legacyId) {
                $query->where('tipospago_id', $legacyId);
            }
        }

        return $query;
    }

    private function generarNumeroRecibo(Temporada $temporada)
    {
        return 'R'.$temporada->temporada.'-'.Contador_recibo::sumar($temporada);
    }

    private function crearPagosPreinscripcion(Preinscripcion $preinscripcion)
    {
        if (is_null($preinscripcion->modalidad_cuotas) || is_null($preinscripcion->miembro_id)) {
            return;
        }

        $plazos = $preinscripcion->plazosPago();
        $tipospagoIds = collect($plazos)->pluck('tipospago_id');

        $yaExisten = Pago::where('miembro_id', $preinscripcion->miembro_id)
            ->where('temporada_id', $preinscripcion->temporada_id)
            ->whereIn('tipospago_id', $tipospagoIds)
            ->exists();

        if ($yaExisten) {
            return;
        }

        $temporada = Temporada::find($preinscripcion->temporada_id);
        $primerRecibo = null;

        foreach ($plazos as $plazo) {
            $nRecibo = $this->generarNumeroRecibo($temporada);
            if (is_null($primerRecibo)) {
                $primerRecibo = $nRecibo;
            }

            Pago::create([
                'miembro_id' => $preinscripcion->miembro_id,
                'temporada_id' => $preinscripcion->temporada_id,
                'tipospago_id' => $plazo['tipospago_id'],
                'importe' => $plazo['importe'],
                'f_vencimiento' => $plazo['f_vencimiento'],
                'f_pago' => null,
                'nRecibo' => $nRecibo,
                'estado' => Pago::ESTADO_PENDIENTE,
            ]);
        }

        if ($primerRecibo) {
            $preinscripcion->nRecibo = $primerRecibo;
            $preinscripcion->save();
        }
    }

    private function assertPublicPreinsSession(Request $request)
    {
        $miembroId = (int) $request->input('miembro_id');
        $sessionMiembro = session(self::PREINS_SESSION_MIEMBRO);
        $sessionOkAt = session(self::PREINS_SESSION_OK_AT);

        if (is_null($sessionMiembro) || is_null($sessionOkAt)) {
            abort(403, 'Debe acceder al formulario mediante el enlace del correo.');
        }

        if ((int) $sessionMiembro !== $miembroId) {
            abort(403, 'La sesión de preinscripción no coincide con el miembro indicado.');
        }

        if (Carbon::parse($sessionOkAt)->addHours(self::PREINS_SESSION_HOURS)->isPast()) {
            session()->forget([self::PREINS_SESSION_MIEMBRO, self::PREINS_SESSION_OK_AT]);
            abort(403, 'El enlace de preinscripción ha caducado. Solicite un nuevo correo al club.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Auth::check()) {
            $this->assertPublicPreinsSession($request);
        }

        if (! is_null($request->input('miembro_id'))) {
            $preExiste = $this->preinscripcionDuplicadaEnTemporadaActual($request->input('miembro_id'));
            if (! is_null($preExiste)) {
                return view('preinscripciones.existe', compact('preExiste'));
            }
        }

        // Si el NIF ya existe en la preinscripción en la temporada actual.
        if (!is_null($request->input('nif'))){
            $preExiste = Preinscripcion::where('nif', $request->input('nif'))->where('temporada_id',Temporada::actual()->id)->first();
            if (!is_null($preExiste)){
                return view("preinscripciones.existe", compact('preExiste'));
            }
        }

        $this->validarPreinscripcion($request);

        // Generar nùmero de preinscripción
        $nPreinscripcion = time();

        // 1.- Guardar los datos en la tabla preinscripciones
        $miembro = new Preinscripcion();

        $miembro->nif = $request->input('nif');

        if (!is_null($request->input('f_nacimiento'))){
            $miembro->f_nacimiento = date('Y-m-d', strtotime($request->input('f_nacimiento')) );
        }

        $miembro->genero_id = $request->input('genero_id');
        $miembro->nombre = $request->input('nombre');
        $miembro->apellido1 = $request->input('apellido1');
        $miembro->apellido2 = $request->input('apellido2');
        $miembro->centroEducativo = $this->normalizarCampoOpcional($request->input('centroEducativo'));
        $miembro->nomSerigrafia = $request->input('nomSerigrafia');
        $miembro->dorsal = $request->input('dorsal');
        $miembro->domicilio = $request->input('domicilio');
        $miembro->c_postal = $request->input('c_postal');
        $miembro->provincia = $request->input('provincia');
        $miembro->localidad = $request->input('localidad');
        $miembro->nombreR1 = $this->normalizarCampoOpcional($request->input('nombreR1'));
        $miembro->apellido1R1 = $this->normalizarCampoOpcional($request->input('apellido1R1'));
        $miembro->apellido2R1 = $request->input('apellido2R1');
        $miembro->nombreR2 = $request->input('nombreR2');
        $miembro->apellido1R2 = $request->input('apellido1R2');
        $miembro->apellido2R2 = $request->input('apellido2R2');
        $miembro->telefono = $request->input('telefono');
        $miembro->telefonoFijo = $request->input('telefonoFijo');
        $miembro->telefonoOtro = $request->input('telefonoOtro');
        $miembro->email = $request->input('email');
        $miembro->miembro_id = $request->input('miembro_id');

        $miembro->temporada_id = Temporada::actual()->id;
        $miembro->estado = 'Pendiente de Pago';

        $miembro->f_preinscripcion = date('Y-m-d', time() );
        $miembro->nPreinscripcion = $nPreinscripcion;

        $miembro->socio = $request->input('socio');
        /* $miembro->normas = $request->input('normas'); */
        $miembro->normas = 'S';
        $miembro->autorizacion = $request->input('autorizacion');

        $miembro->obsEnfermedad = $request->input('obsEnfermedad');
        $miembro->obsAlergia = $request->input('obsAlergia');
        $miembro->obsOtras = $request->input('obsOtras');

        $vPago = $this->aplicarModalidadCuota($miembro, $request);

        DB::transaction(function () use ($miembro) {
            $miembro->save();
            $this->ensureMiembroParaPagos($miembro);
            $this->crearPagosPreinscripcion($miembro);
        });

        session()->forget([self::PREINS_SESSION_MIEMBRO, self::PREINS_SESSION_OK_AT]);

        // 2.- Enviar correo para el pago
         $for = $request->input('email');

        Mail::send('emails.preinsConf', compact('nPreinscripcion', 'vPago'), function($msj) use ($for){
            $msj->subject('Instrucciones para el pago de la preinscripción');
            $msj->to($for);
        });

        return view("preinscripciones.salida", compact('nPreinscripcion', 'vPago'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $preinscripcion = Preinscripcion::find($id);

        if ($preinscripcion && $preinscripcion->miembro_id) {
            $this->queryPagosPreinscripcion($preinscripcion)
                ->whereNull('f_pago')
                ->delete();
        }

        $preinscripcion->delete();

        return redirect()->back()->with('status', 'Preinscripción borrada');
    }

    /* Esta función pasa al estado pagado una preinscripción */
    public function pagado(Preinscripcion $preinscripcion){
        $this->ensureMiembroParaPagos($preinscripcion);

        if ($preinscripcion->modalidad_cuotas) {
            $this->crearPagosPreinscripcion($preinscripcion);
        }

        $pago = $this->queryPagosPreinscripcion($preinscripcion)
            ->whereNull('f_pago')
            ->orderBy('f_vencimiento')
            ->orderBy('id')
            ->first();

        if (is_null($pago) && is_null($preinscripcion->modalidad_cuotas)) {
            $temporada = Temporada::find($preinscripcion->temporada_id);
            $preinscripcion->nRecibo = 'R'.$temporada->temporada.'-'.Contador_recibo::sumar($temporada);

            $pago = new Pago();
            $pago->importe = $preinscripcion->importePago;
            $pago->temporada_id = $preinscripcion->temporada_id;
            $pago->miembro_id = $preinscripcion->miembro_id;
            $pago->nRecibo = $preinscripcion->nRecibo;
            $pago->tipospago_id = Tipospago::where('descripcion', 'Preinscripción')->first()->id;
            $pago->marcarComoPagado();
            $pago->save();
        } elseif (is_null($pago)) {
            return redirect()->back()->withErrors(['No hay pagos pendientes para esta preinscripción.']);
        } else {
            $temporada = Temporada::find($preinscripcion->temporada_id);
            if (empty($pago->nRecibo)) {
                $pago->nRecibo = $this->generarNumeroRecibo($temporada);
            }
            $pago->marcarComoPagado();
            $pago->save();
            $preinscripcion->nRecibo = $pago->nRecibo;
        }

        $preinscripcion->estado = 'Pagado';
        $preinscripcion->f_pago = date('Y-m-d');
        $preinscripcion->save();

        $pdf = PDF::loadview('pdf.preinscripcionPagada', compact('preinscripcion'))->setPaper('a5', 'landscape');

        // Envío de correo con el recibo adjunto
        $for = $preinscripcion->email;
        $nPreinscripcion = $preinscripcion->nPreinscripcion;

        Mail::send('emails.preinsPagada', compact('nPreinscripcion'), function($msj) use ($for, $pdf){
            $msj->subject('Preinscripción Club Balonmano Laguna');
            $msj->to($for);
            $msj->attachData($pdf->output(), 'Recibo.pdf');
        });

        return redirect()->back()->with('status', 'Recibo enviado correctamente');
    }

    public function deshacerPago(Preinscripcion $preinscripcion){
        $preinscripcion->estado = 'Pendiente de Pago';
        $preinscripcion->f_pago = null;
        $preinscripcion->save();

        $pago = $this->queryPagosPreinscripcion($preinscripcion)
            ->whereNotNull('f_pago')
            ->orderBy('f_vencimiento')
            ->orderBy('id')
            ->first();

        if ($pago) {
            $pago->marcarComoPendiente();
            $pago->save();
        }

        return redirect()->back()->with('status', 'Pago deshecho correctamente');
    }

    public function preinsOficinaCreate(Miembro $miembro)
    {
        //$funciones = Funcione::all();
        //$responsables = Miembro::whereNull('f_nacimiento')->orWhere('f_nacimiento', '<', '2000/01/01')->get();
        $generos = Genero::where('descripcion', '!=', 'mixto')->get();
        $temporada = Temporada::actual();
        //$miembro = Miembro::find($miembro_id);
        if (!is_null($miembro)){
            $resp1 = Miembro::find($miembro->responsable1_id);
            $resp2 = Miembro::find($miembro->responsable2_id);
        }
        else{
            $resp1 = null;
            $resp2 = null;
        }
        $telefono = Telefono::where('miembro_id', $miembro->id)->first();
        $email = Email::where('miembro_id', $miembro->id)->first();

        $dorsales = range(1,99);

        return view('preinscripciones.oficinaCreate', compact('generos', 'temporada', 'miembro', 'resp1', 'resp2', 'telefono', 'email', 'dorsales'));
    }

    public function imprimeRecibo($preinscripcion){
        $pdf = PDF::loadview('pdf.preinscripcionPagada', compact('preinscripcion'))->setPaper('a5', 'landscape');
        return $pdf->download('Recibo.pdf');
    }

    public function oficinaStore(Request $request)
    {
        // Ver si ya existe alguna preinscripción dada de alta
        // Si el miembro antiguo ya tiene preinscripción
/*         $preExiste = Preinscripcion::where('miembro_id', $request->input('miembro_id'))->first();
        if (!is_null($preExiste)){
            return view("preinscripciones.existe", compact('preExiste'));
        }
 */

        // Si el NIF ya existe en la preinscripción.
        if (!is_null($request->input('nif'))){
            $preExiste = Preinscripcion::where('nif', $request->input('nif'))->where('temporada_id',Temporada::actual()->id)->first();
            if (!is_null($preExiste)){
                return view("preinscripciones.existe", compact('preExiste'));
            }
        }

        $this->validarPreinscripcion($request);

        // Generar nùmero de preinscripción
        $nPreinscripcion = time();

        // 1.- Guardar los datos en la tabla preinscripciones
        $miembro = new Preinscripcion();

        $miembro->nif = $request->input('nif');

        if (!is_null($request->input('f_nacimiento'))){
            $miembro->f_nacimiento = date('Y-m-d', strtotime($request->input('f_nacimiento')) );
        }

        $miembro->genero_id = $request->input('genero_id');
        $miembro->nombre = $request->input('nombre');
        $miembro->apellido1 = $request->input('apellido1');
        $miembro->apellido2 = $request->input('apellido2');
        $miembro->centroEducativo = $this->normalizarCampoOpcional($request->input('centroEducativo'));
        $miembro->nomSerigrafia = $request->input('nomSerigrafia');
        $miembro->dorsal = $request->input('dorsal');
        $miembro->domicilio = $request->input('domicilio');
        $miembro->c_postal = $request->input('c_postal');
        $miembro->provincia = $request->input('provincia');
        $miembro->localidad = $request->input('localidad');
        $miembro->nombreR1 = $this->normalizarCampoOpcional($request->input('nombreR1'));
        $miembro->apellido1R1 = $this->normalizarCampoOpcional($request->input('apellido1R1'));
        $miembro->apellido2R1 = $request->input('apellido2R1');
        $miembro->nombreR2 = $request->input('nombreR2');
        $miembro->apellido1R2 = $request->input('apellido1R2');
        $miembro->apellido2R2 = $request->input('apellido2R2');
        $miembro->telefono = $request->input('telefono');
        $miembro->telefonoFijo = $request->input('telefonoFijo');
        $miembro->telefonoOtro = $request->input('telefonoOtro');
        $miembro->email = $request->input('email');
        $miembro->miembro_id = $request->input('miembro_id');

        $miembro->temporada_id = Temporada::actual()->id;
        $miembro->estado = 'Pendiente de Pago';

        $miembro->f_preinscripcion = date('Y-m-d', time() );
        $miembro->nPreinscripcion = $nPreinscripcion;

        $miembro->obsEnfermedad = $request->input('obsEnfermedad');
        $miembro->obsAlergia = $request->input('obsAlergia');
        $miembro->obsOtras = $request->input('obsOtras');

        $miembro->socio = $request->input('socio');
        $miembro->autorizacion = $request->input('autorizacion');
        $miembro->normas = 'S';

        $this->aplicarModalidadCuota($miembro, $request);

        DB::transaction(function () use ($miembro) {
            $miembro->save();
            $this->ensureMiembroParaPagos($miembro);
            $this->crearPagosPreinscripcion($miembro);
        });

        return redirect()->route('miembros')->with('status', 'Preinscripción realizada correctamente');
    }

    public function prePago(Preinscripcion $preinscripcion){
        //dd ($preinscripcion);

        return view("preinscripciones.prepago", compact('preinscripcion'));
    }
}
