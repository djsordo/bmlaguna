<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use BMLaguna\InformeFisicoTecnicoTactico;
use BMLaguna\Miembro;
use BMLaguna\Temporada;

class InformeFttController extends Controller
{
    /**
     * Mantenimiento del informe físico-técnico-táctico por jugador y temporada.
     */
    public function index(Request $request, Miembro $miembro)
    {
        if (! $miembro->esJugadorClub()) {
            abort(404);
        }

        $temporadas = Temporada::orderBy('temporada', 'desc')->get();

        $tempSel = null;
        if ($request->filled('temporada_id')) {
            $tempSel = Temporada::find($request->get('temporada_id'));
        }
        if (! $tempSel) {
            $tempSel = Temporada::Tactual();
        }
        if (! $tempSel && $temporadas->isNotEmpty()) {
            $tempSel = $temporadas->first();
        }

        $informe = null;
        $categoriaEquipo = null;
        $origenTecnicos = 'club';
        $tecnicosDisponibles = collect();

        if ($tempSel) {
            $informe = InformeFisicoTecnicoTactico::firstOrNew([
                'miembro_id' => $miembro->id,
                'temporada_id' => $tempSel->id,
            ]);
            if ($informe->exists) {
                $informe->load('tecnico');
            }
            $categoriaEquipo = $miembro->categoriaComoJugadorEnTemporada($tempSel);
            $packed = $miembro->tecnicosDisponiblesParaInformeFtt($tempSel, $informe->exists ? $informe : null);
            $origenTecnicos = $packed['origen'];
            $tecnicosDisponibles = $packed['tecnicos'];
        }

        return view('informesFtt.index', compact(
            'miembro',
            'temporadas',
            'tempSel',
            'informe',
            'categoriaEquipo',
            'origenTecnicos',
            'tecnicosDisponibles'
        ));
    }

    public function update(Request $request, Miembro $miembro)
    {
        if (! $miembro->esJugadorClub()) {
            abort(404);
        }

        $temporada = Temporada::findOrFail($request->input('temporada_id'));
        $existente = InformeFisicoTecnicoTactico::where('miembro_id', $miembro->id)
            ->where('temporada_id', $temporada->id)
            ->first();
        $packed = $miembro->tecnicosDisponiblesParaInformeFtt($temporada, $existente);
        $tecnicos = $packed['tecnicos'];

        $rules = [
            'temporada_id' => 'required|exists:temporadas,id',
            'texto' => 'nullable|string',
        ];
        if ($tecnicos->isNotEmpty()) {
            $rules['tecnico_id'] = ['required', 'exists:miembros,id', Rule::in($tecnicos->pluck('id')->all())];
        } else {
            $rules['tecnico_id'] = 'nullable';
        }

        $request->validate($rules);

        $categoria = $miembro->categoriaComoJugadorEnTemporada($temporada);

        InformeFisicoTecnicoTactico::updateOrCreate(
            [
                'miembro_id' => $miembro->id,
                'temporada_id' => $temporada->id,
            ],
            [
                'texto' => $request->input('texto'),
                'categoria_id' => $categoria ? $categoria->id : null,
                'tecnico_id' => $request->filled('tecnico_id') ? (int) $request->input('tecnico_id') : null,
            ]
        );

        return redirect()
            ->route('informesFtt', ['miembro' => $miembro->id, 'temporada_id' => $temporada->id])
            ->with('status', 'Informe guardado correctamente.');
    }
}
