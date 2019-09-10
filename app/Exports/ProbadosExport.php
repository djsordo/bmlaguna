<?php

namespace BMLaguna\Exports;

use BMLaguna\Miembro;
use BMLaguna\Categoria;
use BMLaguna\Temporada;
use BMLaguna\Talla;

use DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProbadosExport implements FromCollection, WithHeadings, WithColumnFormatting, WithMapping
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
            'Categoría',
            'Género',
            'Dorsal',
            'Nombre serigrafía'];

        foreach ($temporada->equipaciones()->get() as $equipacion){
            array_push ($cabecera, $equipacion->descripcion);
        } 

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
            Miembro::categoriaEdad($miembro->f_nacimiento, Temporada::TActual()->temporada)->descripcion,
            $miembro->descripcion,
            $miembro->dorsal,
            $miembro->nomSerigrafia
        ];

        foreach ($temporada->equipaciones()->get() as $equipacion){
            if (!is_null($equipsMiembro->find($equipacion->id))){
                $talla = Talla::find($equipsMiembro->find($equipacion->id)->pivot->talla_id);
                array_push($cuerpo, $talla->descripcion);
            }
            else{
                array_push($cuerpo, null);
            }
        }

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

        $miembros = DB::table('miembros')
                    ->join('equipacione_miembro_talla', 'miembros.id', '=', 'equipacione_miembro_talla.miembro_id')
                    ->join('equipaciones', 'equipacione_miembro_talla.equipacione_id', '=', 'equipaciones.id')
                    ->join('tallas', 'tallas.id', '=', 'equipacione_miembro_talla.talla_id')
                    ->join('generos', 'generos.id', '=', 'miembros.genero_id')
                    ->where('equipaciones.temporada_id', $temporada->id)
                    ->select('miembros.id', 'miembros.nombre', 'miembros.apellido1', 'miembros.apellido2', 'miembros.f_nacimiento', 'generos.descripcion', 'miembros.dorsal', 'miembros.nomSerigrafia')
                    ->groupBy('miembros.id', 'miembros.nombre', 'miembros.apellido1', 'miembros.apellido2', 'miembros.f_nacimiento', 'generos.descripcion', 'miembros.dorsal', 'miembros.nomSerigrafia')->get();
        // dd($miembros);
        return $miembros;
        
    }
}