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
        //dd(array_keys($request->all()));
        //dd($request->all());
        $criterios = [
            'temporada_id' => $request->input('excelTemp_id'),
            'categoria_id' => $request->input('excelCat_id'),
            'genero_id' => $request->input('excelGen_id'),
            'nombre' => $request->input('excelNombre'),
            'baja' => $request->input('excelBaja'),
            'equipo_id' => $request->input('excelEqui_id'),
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
/* dd($campos); */
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
