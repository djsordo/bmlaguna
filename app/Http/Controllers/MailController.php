<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Session;
use Redirect;

use BMLaguna\Email;
use BMLaguna\Equipo;
use BMLaguna\Miembro;

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

    public function preinsEquipo($equipo_id){
        // Esta función envía un correo de preinscripción a un equipo concreto
        $equipo = Equipo::find($equipo_id);
        $jugadores = $equipo->jugadores()->get();
//dd($jugadores);
       
        $cadena = '';

        foreach ($jugadores as $jugador){
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

        //dd($cadena);
        return redirect()->back()->with('status', 'Correos de preinscripciones enviados');
    }
}
