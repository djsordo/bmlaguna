<?php

namespace BMLaguna\Exports;

use BMLaguna\Miembro;
use BMLaguna\Temporada;

use DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class EstadoDNIExport implements FromCollection, WithHeadings, WithColumnFormatting, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        $temporada = Temporada::Tactual();

        $cabecera = [
            'Nombre',
            'Primer Apellido',
            'Segundo Apellido',
            'Fecha de nacimiento',
            'Estado DNI'];

        return $cabecera;
    }

    public function map($miembro): array
    {
        $temporada = Temporada::Tactual();
        $equipsMiembro = Miembro::find($miembro->id)->equipaciones()->get();

        $cuerpo = [
            $miembro->nombre,
            $miembro->apellido1,
            $miembro->apellido2,
            date('d-m-Y', strtotime($miembro->f_nacimiento)),
            $miembro->estadoNIF()
        ];

        return $cuerpo;
        }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function collection()
    {
        $temporada = Temporada::Tactual();

        $miembros = Miembro::whereNull('f_baja')
                            ->get();

        list($preinscritos, $noPreinscritos) = $miembros->partition(function ($miembro) {
            return $miembro->preinscrito();
        });
        // dd($preinscritos);
        return $preinscritos;
        
    }
}