<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Mail;
use Session;
use Redirect;

use BMLaguna\Email;
use BMLaguna\Equipo;
use BMLaguna\Miembro;
use BMLaguna\Temporada;
use BMLaguna\Preinscripcion;
use BMLaguna\Pago;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Mail::send('emails.correo',[], function($msj){
            $msj->subject('Correo de contacto');
            $msj->to('ajvitores@gmail.com');

        });

        
        return Redirect::to('/miembros');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Mail::send('emails.correo', $request, function($msj){
            $msj->subject('Correo de contacto');
            $msj->to('ajvitores@gmail.com');

        });

        Session::flash('message', 'Mensaje enviado correctamente');
        return Redirect::to('/miembros');
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
        //
    }

    // Esta función envía el primer correo genérico de preinscripción (El correo con las instrucciones de pago)
    public function preinsGenerica($miembro_id){
        $preinscripcion = Preinscripcion::find($miembro_id);
        
        $for = $preinscripcion->email;
        
        $nPreinscripcion = $preinscripcion->nPreinscripcion;
        $vPago = $preinscripcion->importePago;

        Mail::send('emails.preinsConf', compact('nPreinscripcion', 'vPago'), function($msj) use ($for){
            $msj->subject('Instrucciones para el pago de la preinscripción');
            $msj->to($for);
        });

        return redirect()->back()->with('status', 'Correo de preinscripción enviado correctamente');
    }

    // Esta función envía el segundo correo genérico de inscripción (El correo con la factura de el pago una vez realizado)
    public function insGenerica($miembro_id){
        $preinscripcion = Preinscripcion::find($miembro_id);
        
        $for = $preinscripcion->email;
        
        $nPreinscripcion = $preinscripcion->nPreinscripcion;
        
        $pdf = PDF::loadview('pdf.preinscripcionPagada', compact('preinscripcion'))->setPaper('a5', 'landscape');
        
        // Envío de correo con el recibo adjunto
        Mail::send('emails.preinsPagada', compact('nPreinscripcion'), function($msj) use ($for, $pdf){
            $msj->subject('Inscripción Club Balonmano Laguna');
            $msj->to($for);
            $msj->attachData($pdf->output(), 'Recibo.pdf');
        });

        return redirect()->back()->with('status', 'Correo de Inscripción enviado correctamente');
    }

    // Esta función envía un recibo al correo indicado
    public function reciboPago($pago_id, $cuota, $pagado, $correo){
        //dd($correo);
        $pago = Pago::find($pago_id);
        $miembro = Miembro::find($pago->miembro_id);

        $pdf = PDF::loadview('pdf.reciboPago', compact('pago', 'miembro', 'cuota', 'pagado'))->setPaper('a5', 'landscape');

        $for = $correo;

        // Envío de correo con el recibo adjunto
        Mail::send('emails.recibo', compact('pago'), function($msj) use ($for, $pdf, $pago){
            $msj->subject('Recibo '.$pago->nRecibo.' Club Balonmano Laguna');
            $msj->to($for);
            $msj->attachData($pdf->output(), 'Recibo_'.$pago->nRecibo.'.pdf');
        });

        return redirect()->back()->with('status', 'Recibo enviado correctamente a la dirección '.$correo);
    }

    public function preinsAntiguos($miembro_id){
        $email = Email::where('miembro_id', $miembro_id)->first();

        if (is_null($email)){
            return redirect()->back()->with('status', 'No existe dirección de correo para este miembro');    
        }

        $for = $email->email;

        Mail::send('emails.preinsAntiguos', compact('miembro_id'), function($msj) use ($for){
            $msj->subject('Preinscripcion Club Balonmano Laguna');
            $msj->to($for);
        });

        return redirect()->back()->with('status', 'Correo de preinscripción enviado correctamente');
    }
 
    public function insAntiguos($miembro_id, $pendiente){
        //dd($pendiente);
        $email = Email::where('miembro_id', $miembro_id)->first();
        $miembro = Miembro::find($miembro_id);
        $tActual = Temporada::Tactual();

        if (is_null($email)){
            return redirect()->back()->with('status', 'No existe dirección de correo para este miembro');    
        }

        $for = $email->email;

        Mail::send('emails.insAntiguos', compact('miembro', 'tActual', 'pendiente'), function($msj) use ($for){
            $msj->subject('Inscripcion Club Balonmano Laguna');
            $msj->to($for);
            $msj->attach(public_path('docsInscripcion/Normas.pdf'),
                            [
                                'as' => 'Normas.pdf',
                                'mime' => 'application/pdf',
                            ]);
            $msj->attach(public_path('docsInscripcion/Protocolo.pdf'),
                            [
                                'as' => 'Protocolo.pdf',
                                'mime' => 'application/pdf',
                            ]);
            $msj->attach(public_path('docsInscripcion/Autorizacion.pdf'),
                            [
                                'as' => 'Autorizacion.pdf',
                                'mime' => 'application/pdf',
                            ]);
        });

        return redirect()->back()->with('status', 'Correo de inscripción enviado correctamente');
    }

    public function preinsEquipo($equipo_id){
        // Esta función envía un correo de preinscripción a un equipo concreto
        $equipo = Equipo::find($equipo_id);
        $jugadores = $equipo->jugadores()->get();
//dd($jugadores);
       
        $cadena = '';

        foreach ($jugadores as $jugador){
            $email = Email::where('miembro_id', $jugador->id)->first();
            if (!is_null($email)){
                $for = $jugador->emails()->first()->email;
                $miembro_id = $jugador->id;

                if (!is_null($for)){
                    // Envío del mensaje
                    Mail::send('emails.preinsAntiguos', compact('miembro_id'), function($msj) use ($for){
                        $msj->subject('Preinscripcion Club Balonmano Laguna');
                        $msj->to($for);
                    });
                    $cadena = $cadena . '<p>' . $jugador->nombre . ' ' . $jugador->apellido1 . ' ' . $jugador->apellido2 . '->' . $for . ' : Enviado Correctamente'; 
                    sleep(1);
                }
                else{
                    $cadena = $cadena . '<p>' . $jugador->nombre . ' ' . $jugador->apellido1 . ' ' . $jugador->apellido2 . '->' . 'Sin Correo electrónico' . ' : No se ha podido enviar'; 
                }
            }
        }

        //dd($cadena);
        return redirect()->back()->with('status', 'Correos de preinscripciones enviados');
    }
}
