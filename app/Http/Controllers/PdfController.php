<?php

namespace BMLaguna\Http\Controllers;

Use BMLaguna\Miembro;
use BMLaguna\Preinscripcion;
use BMLaguna\Temporada;
use BMLaguna\Equipo;
use BMLaguna\Categoria;
use BMLaguna\Pago;

use Dompdf\Dompdf;
use Dompdf\Options;


use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;


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

    public function preinscripcionPagada(Preinscripcion $preinscripcion){
        
        // 1.- Sacar datos de la preinscripcion
        //$preinscripcion = Preinscripcion::find($id);
        
        $pdf = PDF::loadview('pdf.preinscripcionPagada', compact('preinscripcion'))->setPaper('a5', 'landscape');
        
        return $pdf->download('preinscripcion-'.$preinscripcion->nPreinscripcion.'.pdf');
    }

    public function imprimirRecibo($preinscripcion){
        $pdf = PDF::loadview('pdf.preinscripcionPagada', compact('preinscripcion'))->setPaper('a5', 'landscape');
        return $pdf->download('Recibo.pdf');
    }

    public function certFedeReco(Miembro $miembro){
        $tempActual = Temporada::Tactual();

        $pdf = PDF::loadview('pdf.certFedeReco', compact('miembro', 'tempActual'))->setPaper('a4', 'portrait');

        return $pdf->download('certFedeReco-'.$miembro->apellido1.$miembro->apellido2.$miembro->nombre.'.pdf');
        
    }

    public function certFedeRecoEquipo(Equipo $equipo){
        $tempActual = $equipo->temporada;
        $zipFile = 'certsRecoEquipo.zip';
        $path = 'certificados/';

        $zip = new \ZipArchive();
        $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        //return dd($path);
        foreach ($equipo->jugadores as $miembro){
            $nombreFichero = 'certFedeReco-'.$miembro->apellido1.$miembro->apellido2.$miembro->nombre . '.pdf';
            $pdf = PDF::loadview('pdf.certFedeReco', compact('miembro', 'tempActual'))->setPaper('a4', 'portrait');
            $pdf->save($path . $nombreFichero);
            $zip->addFile($path . $nombreFichero);
            
        }
        $zip->close();

        // Código para borrar los ficheros de un directorio
        $files = glob($path . '*');
        foreach($files as $file){
            if(is_file($file)){
                unlink($file);
            }
        }

        return response()->download('./'.$zipFile);
    }

    public function reciboPago($pago_id, $cuota, $pagado){
        $pago = Pago::find($pago_id);
        $miembro = Miembro::find($pago->miembro_id);

        //$formatterES = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
        //$importeLetra = $formatterES->format($pago->importe);

        $pdf = PDF::loadview('pdf.reciboPago', compact('pago', 'miembro', 'cuota', 'pagado'))->setPaper('a5', 'landscape');
        
        return $pdf->download('recibo-'.$pago->nRecibo.'.pdf');
    }

    public function cuotas(Temporada $temporada){
        //$miembro = Miembro::find($miembro_id);
        $categorias = Categoria::orderBy('orden', 'ASC')->get();
//dd($categorias);
        $pdf = PDF::loadview('pdf.cuotas', compact('temporada', 'categorias'))->setPaper('a4', 'portrait');
        
        return $pdf->download('cuotas.pdf');
    }

}
