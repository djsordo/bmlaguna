<?php

namespace BMLaguna\Exports;

use BMLAguna\Miembro;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MiembrosExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Id',
            'Nombre',
            'Primer Apellido',
            'segundo Apellido'
        ];
    }
    public function collection()
    {
         $miembros = DB::table('miembros')->select('id','nombre', 'apellido1', 'apellido2')->get();
         return $miembros;
        
    }
}