<?php

namespace BMLaguna\Http\Controllers;

Use BMLaguna\Miembro;
use Dompdf\Dompdf;
use Dompdf\Options;


use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
// use Barryvdh\DomPDF\PDF;

class PdfController extends Controller
{
    public function preinscripcion($miembro_id){
        $miembro = Miembro::find($miembro_id);
        $resp1 = new Miembro;
        $resp2 = new Miembro;
        
        if (!is_null($miembro->responsable1_id)){
            $resp1 = Miembro::find($miembro->responsable1_id);
        }

        if (!is_null($miembro->responsable2_id)){
            $resp2 = Miembro::find($miembro->responsable2_id);
        }
        
        $pdf = PDF::loadview('pdf.preinscripcion', compact('miembro', 'resp1', 'resp2'))->setPaper('a4', 'portrait');
        
        return $pdf->download('preinscripcion-'.$miembro->nombre.$miembro->apellido1.'.pdf');
    }

    public function equipacion($miembro_id){
        $miembro = Miembro::find($miembro_id);
     
        $pdf = PDF::loadview('pdf.equipacion', compact('miembro'))->setPaper('a4', 'portrait');
        
        return $pdf->download('equipacion.pdf');
    }

}
