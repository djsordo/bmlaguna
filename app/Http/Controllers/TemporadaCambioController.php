<?php

namespace BMLaguna\Http\Controllers;

use BMLaguna\Temporada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TemporadaCambioController extends Controller
{
    public function index()
    {
        $temporadas = Temporada::orderBy('temporada')->get();
        $temporadaActual = Temporada::Tactual();

        $siguienteAnio = null;
        $siguienteDescripcion = null;
        $puedeAvanzar = false;

        if ($temporadaActual) {
            $siguienteAnio = $temporadaActual->siguienteAnio();
            $siguienteDescripcion = $temporadaActual->siguienteDescripcion();
            $puedeAvanzar = ! Temporada::where('temporada', $siguienteAnio)->exists();
        }

        $datosVinculados = $temporadaActual
            ? $temporadaActual->conteoDatosVinculados()
            : [];

        $totalDatosVinculados = $temporadaActual
            ? $temporadaActual->totalDatosVinculados()
            : 0;

        $puedeRevertir = $temporadas->count() >= 2;

        return view('temporada_cambio.index', compact(
            'temporadas',
            'temporadaActual',
            'siguienteAnio',
            'siguienteDescripcion',
            'puedeAvanzar',
            'datosVinculados',
            'totalDatosVinculados',
            'puedeRevertir'
        ));
    }

    public function avanzar(Request $request)
    {
        $temporadaActual = Temporada::Tactual();

        if (is_null($temporadaActual)) {
            return redirect()
                ->route('temporada-cambio')
                ->withErrors(['No hay temporada actual definida.']);
        }

        $siguienteAnio = $temporadaActual->siguienteAnio();
        $siguienteDescripcion = $temporadaActual->siguienteDescripcion();

        if (Temporada::where('temporada', $siguienteAnio)->exists()) {
            return redirect()
                ->route('temporada-cambio')
                ->withErrors(['La temporada '.$siguienteDescripcion.' ya existe.']);
        }

        $request->validate([
            'confirmacion' => ['required', function ($attribute, $value, $fail) use ($siguienteDescripcion) {
                if ($value !== $siguienteDescripcion) {
                    $fail('Debe escribir exactamente la descripción de la nueva temporada ('.$siguienteDescripcion.').');
                }
            }],
            'acepto' => 'accepted',
        ], [
            'acepto.accepted' => 'Debe aceptar las condiciones para continuar.',
        ]);

        DB::transaction(function () use ($siguienteAnio, $siguienteDescripcion) {
            Temporada::create([
                'temporada' => $siguienteAnio,
                'descripcion' => $siguienteDescripcion,
            ]);
        });

        return redirect()
            ->route('temporada-cambio')
            ->with('status', 'Temporada '.$siguienteDescripcion.' abierta correctamente. La aplicación ya apunta a la nueva temporada.');
    }

    public function revertir(Request $request)
    {
        $temporadaActual = Temporada::Tactual();

        if (Temporada::count() < 2) {
            return redirect()
                ->route('temporada-cambio')
                ->withErrors(['Debe existir al menos una temporada anterior para poder revertir.']);
        }

        if (is_null($temporadaActual)) {
            return redirect()
                ->route('temporada-cambio')
                ->withErrors(['No hay temporada actual definida.']);
        }

        $descripcionActual = $temporadaActual->descripcion;
        $totalDatos = $temporadaActual->totalDatosVinculados();

        $rules = [
            'confirmacion' => ['required', function ($attribute, $value, $fail) use ($descripcionActual) {
                if ($value !== $descripcionActual) {
                    $fail('Debe escribir exactamente la descripción de la temporada a eliminar ('.$descripcionActual.').');
                }
            }],
            'acepto' => 'accepted',
        ];

        if ($totalDatos > 0) {
            $rules['acepto_datos'] = 'accepted';
        }

        $request->validate($rules, [
            'acepto.accepted' => 'Debe aceptar las condiciones para continuar.',
            'acepto_datos.accepted' => 'Debe confirmar que entiende el riesgo de eliminar una temporada con datos vinculados.',
        ]);

        $descripcionEliminada = $temporadaActual->descripcion;

        DB::transaction(function () use ($temporadaActual) {
            $temporadaActual->delete();
        });

        $temporadaRestaurada = Temporada::Tactual();
        $mensaje = 'Temporada '.$descripcionEliminada.' eliminada.';

        if ($temporadaRestaurada) {
            $mensaje .= ' Temporada activa: '.$temporadaRestaurada->descripcion.'.';
        }

        return redirect()
            ->route('temporada-cambio')
            ->with('status', $mensaje);
    }
}
