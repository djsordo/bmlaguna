<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use BMLaguna\Exports\MiembrosExport;
use BMLaguna\Exports\PreinscripcionesExport;
use BMLaguna\Exports\ProbadosExport;
use BMLaguna\Exports\ProbadosPrendaExport;
use BMLaguna\Exports\EstadoDNIExport;

use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function exportMiembros(){
        return Excel::download(new MiembrosExport, 'miembros.xlsx');
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
