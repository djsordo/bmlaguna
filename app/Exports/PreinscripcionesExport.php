<?php

namespace BMLaguna\Exports;

use BMLaguna\Miembro;
use BMLaguna\Categoria;
use BMLaguna\Temporada;
use BMLaguna\Email;
use BMLaguna\Telefono;

use DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class PreinscripcionesExport implements FromCollection, WithHeadings, WithColumnFormatting, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'NIF',
            'Nombre',
            'Primer Apellido',
            'Segundo Apellido',
            'Persona de contacto',
            'Dirección',
            'Código Postal',
            'Provincia',
            'Población',
            'eMail',
            'Teléfono',
            'Fecha de nacimiento',
            'Fecha de pago',
            'Categoría',
            'Género',
            'Dorsal'
        ];
    }

    public function map($miembro): array
    {
        //$email = Email::where('miembro_id', $miembro->id)->first()->email;
        //dd($email->email);
        $emails = Email::where('miembro_id', $miembro->id)->get();
        $telefonos = Telefono::where('miembro_id', $miembro->id)->get();
        
        $correo = '';
        foreach($emails as $email){
            $correo = $email->email;
        }

        $telef = '';
        foreach($telefonos as $telefono){
            $telef = $telefono->telefono;
        }

        $responsable = '';
        if (!is_null($miembro->responsable1_id)){
            $responsableV = Miembro::find($miembro->responsable1_id);
            //dd($responsableV);
            $responsable = $responsableV->nombre.' '.$responsableV->apellido1.' '.$responsableV->apellido2;
        }
        elseif (!is_null($miembro->responsable2_id)){
            $responsableV = Miembro::find($miembro->responsable2_id);
            $responsable = $responsableV->nombre.' '.$responsableV->apellido1.' '.$responsableV->apellido2;
        }

        return [
            $miembro->nif,
            $miembro->nombre,
            $miembro->apellido1,
            $miembro->apellido2,
            $responsable,
            $miembro->domicilio,
            $miembro->c_postal,
            $miembro->provincia,
            $miembro->localidad,
            $correo,
            $telef,
            date('d-m-Y', strtotime($miembro->f_nacimiento)),
            date('d-m-Y', strtotime($miembro->f_pago)),
            Miembro::categoriaEdad($miembro->f_nacimiento, Temporada::TActual()->temporada)->descripcion,
            $miembro->descripcion,
            $miembro->dorsal
        ];
        }

    public function columnFormats(): array
    {
        return [
            'L' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'M' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function collection()
    {
        $temporada = Temporada::Tactual();

        $miembros = DB::table('miembros')
                    ->join('pagos', 'miembros.id', '=', 'pagos.miembro_id')
                    ->join('tipospagos', 'tipospagos.id', '=', 'pagos.tipospago_id')
                    ->join('generos', 'genero_id', '=', 'generos.id')
                    ->where('tipospagos.descripcion','Preinscripcion')
                    ->where('pagos.temporada_id', $temporada->id)
                    ->select('miembros.nif', 'miembros.id', 'miembros.nombre', 'miembros.apellido1', 'miembros.apellido2', 'miembros.f_nacimiento', 'miembros.domicilio', 'miembros.localidad', 'miembros.provincia', 'miembros.c_postal', 'miembros.responsable1_id', 'miembros.responsable2_id', 'miembros.dorsal', 'pagos.f_pago', 'generos.descripcion')->get();

        // dd($miembros);
        return $miembros;
        
    }
}