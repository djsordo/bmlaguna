<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use BMLaguna\Exports\MiembrosExport;
use BMLaguna\Exports\PreinscripcionesExport;
use BMLaguna\Exports\ProbadosExport;
use BMLaguna\Exports\ProbadosPrendaExport;
use BMLaguna\Exports\EstadoDNIExport;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class ExcelController extends Controller
{
    public function exportMiembros(Request $request){
        $vacioANull = function ($valor) {
            return ($valor === null || $valor === '') ? null : $valor;
        };

        $criterios = [
            'temporada_id' => $vacioANull($request->input('excelTemp_id')),
            'categoria_id' => $vacioANull($request->input('excelCat_id')),
            'genero_id' => $vacioANull($request->input('excelGen_id')),
            'nombre' => $vacioANull($request->input('excelNombre')),
            'baja' => $request->input('excelBaja'),
            'equipo_id' => $vacioANull($request->input('excelEqui_id')),
            'socio' => $vacioANull($request->input('excelSocio')),
            'rol_club' => $vacioANull($request->input('excelRolClub')),
        ];

        $camposAux =  array_keys($request->all());

        $campos= [];
        $i = 0;
        foreach ($camposAux as $campo){
            //dd(strpos($campo, 'check'));
            if (Str::startsWith($campo, 'check')){
                $campos[$i] = $campo;
                $i++;
            }
        }
        if (empty($campos)) {
            return back()->with('error', 'Debe seleccionar al menos un campo para exportar.');
        }

        return Excel::download(new MiembrosExport($criterios, $campos), 'miembros.xlsx');
    }

    public function exportPreinscripciones(){
        return Excel::download(new PreinscripcionesExport, 'preinscripciones.xlsx');
    }

    public function exportProbados(){
        return Excel::download(new ProbadosExport, 'probados.xlsx');
    }

    public function exportProbadosPrenda(){
        return Excel::download(new ProbadosPrendaExport, 'probadosPrenda.xlsx');
    }

    public function exportEstadoDNI(){
        return Excel::download(new EstadoDNIExport, 'EstadoDNI.xlsx');
    }
}
