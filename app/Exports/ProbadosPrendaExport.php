<?php

namespace BMLaguna\Exports;

use BMLaguna\Temporada;
use BMLaguna\Talla;
use BMLaguna\Equipacione;

use DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProbadosPrendaExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        $tallas = Talla::all();
        // $temporada = Temporada::Tactual();

        $cabecera = [
            'Prenda', 'Talla', 'Unidades'
            ];

        return $cabecera;
    }

     public function map($dato): array
     {
         $equipacion = Equipacione::find($dato->equipacione_id);
         $talla = Talla::find($dato->talla_id);

         $cuerpo = [
             $equipacion->descripcion,
             $talla->descripcion,
             $dato->cuenta,
         ];

         return $cuerpo;
         }

    public function collection()
    {
        
        $temporada = Temporada::Tactual();

        $datos = DB::select('select emt.equipacione_id, emt.talla_id, count(*) as cuenta from equipacione_miembro_talla emt, equipaciones e
                          where	e.id = emt.equipacione_id and
                                e.temporada_id = ? and
                                emt.f_pedido is null
                          group by emt.equipacione_id, emt.talla_id', [$temporada->id]);

        return collect($datos);
    }
}