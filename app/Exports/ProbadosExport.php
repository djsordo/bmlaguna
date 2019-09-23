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
            array_push ($cabecera, 'Fecha de Prueba');
            array_push ($cabecera, 'Fecha de Pedido');
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
                $f_prueba = $equipsMiembro->find($equipacion->id)->pivot->f_prueba;
                $f_pedido = $equipsMiembro->find($equipacion->id)->pivot->f_pedido;
                if (!is_null($f_prueba)){
                    array_push($cuerpo, date('d-m-Y', strtotime($f_prueba)));    
                }
                else{
                    array_push($cuerpo, $f_prueba);    
                }
                
                if (!is_null($f_pedido)){
                    array_push($cuerpo, date('d-m-Y', strtotime($f_pedido)));
                }
                else{
                    array_push($cuerpo, $f_pedido);    
                }
                
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
            'J' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'K' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'M' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'N' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'P' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'Q' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'S' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'T' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'V' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'W' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'Y' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'Z' => NumberFormat::FORMAT_DATE_DDMMYYYY,
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