<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use BMLaguna\Equipo;
use BMLaguna\Funcione;
use BMLaguna\Temporada;

class TecnicoController extends Controller
{
    /**
     * Listado de técnicos agrupados por miembro, con asignaciones por equipo en cada acordeón.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $temporadas = Temporada::orderBy('temporada', 'desc')->get();
        $tempActual = Temporada::Tactual();

        $temporadaId = $request->get('temporada_id');
        if ($temporadaId === null || $temporadaId === '') {
            if ($tempActual) {
                $temporadaId = $tempActual->id;
            } elseif ($temporadas->isNotEmpty()) {
                $temporadaId = $temporadas->first()->id;
            } else {
                $temporadaId = null;
            }
        }

        $equipos = collect();
        if ($temporadaId) {
            $equipos = Equipo::where('temporada_id', $temporadaId)->orderBy('nombre')->get();
        }

        $nombreBusqueda = $request->get('nombreBusqueda', '');
        $equipoId = $request->get('equipo_id');

        $tecnicos = null;

        if ($temporadaId) {
            $rolesOficial = Funcione::rolesOficialEquipo();

            // No filtrar por f_baja: deben listarse también técnicos dados de baja en el club.
            $query = DB::table('equipo_funcione_miembro')
                ->join('equipos', 'equipo_funcione_miembro.equipo_id', '=', 'equipos.id')
                ->join('miembros', 'equipo_funcione_miembro.miembro_id', '=', 'miembros.id')
                ->join('funciones', 'equipo_funcione_miembro.funcione_id', '=', 'funciones.id')
                ->where('equipos.temporada_id', $temporadaId)
                ->whereIn('funciones.descripcion', $rolesOficial);

            if (trim($nombreBusqueda) !== '') {
                $texto = str_replace(' ', '%', trim($nombreBusqueda));
                $query->where(
                    DB::raw("concat(miembros.nombre, ' ', miembros.apellido1, ' ', IFNULL(miembros.apellido2, ' '))"),
                    'like',
                    '%'.$texto.'%'
                );
            }

            if ($equipoId !== null && $equipoId !== '') {
                $query->where('equipos.id', $equipoId);
            }

            $raw = $query
                ->select(
                    'miembros.id as miembro_id',
                    'miembros.nombre',
                    'miembros.apellido1',
                    'miembros.apellido2',
                    'equipos.id as equipo_id',
                    'equipos.nombre as equipo_nombre',
                    'funciones.descripcion as funcion_descripcion'
                )
                ->orderBy('miembros.apellido1')
                ->orderBy('miembros.nombre')
                ->orderBy('equipos.nombre')
                ->get();

            $agrupados = $raw->groupBy('miembro_id')->map(function (Collection $items) {
                $first = $items->first();

                return (object) [
                    'miembro_id' => $first->miembro_id,
                    'nombre_completo' => trim($first->nombre.' '.$first->apellido1.' '.$first->apellido2),
                    'asignaciones' => $items->map(function ($r) {
                        return (object) [
                            'equipo_id' => $r->equipo_id,
                            'equipo_nombre' => $r->equipo_nombre,
                            'funcion_descripcion' => $r->funcion_descripcion,
                        ];
                    })->sortBy('equipo_nombre')->values(),
                ];
            })->sortBy(function ($g) {
                return $g->nombre_completo;
            })->values();

            $porPagina = 10;
            $pagina = max(1, (int) $request->get('page', 1));
            $total = $agrupados->count();
            $itemsPagina = $agrupados->slice(($pagina - 1) * $porPagina, $porPagina)->values();

            $tecnicos = new LengthAwarePaginator(
                $itemsPagina,
                $total,
                $porPagina,
                $pagina,
                ['path' => $request->url(), 'pageName' => 'page']
            );
            $tecnicos->appends($request->only(['temporada_id', 'nombreBusqueda', 'equipo_id']));
        }

        $path = $request->url();

        return view(
            'tecnicos.index',
            compact(
                'tecnicos',
                'temporadas',
                'temporadaId',
                'tempActual',
                'equipos',
                'nombreBusqueda',
                'equipoId',
                'path'
            )
        );
    }
}
