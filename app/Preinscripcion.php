<?php

namespace BMLaguna;

use BMLaguna\Genero;
use BMLaguna\Miembro;
use BMLaguna\Temporada;
use BMLaguna\Categoria;
use BMLaguna\Tipospago;

use Illuminate\Database\Eloquent\Model;

class Preinscripcion extends Model
{
    protected $fillable = ['nif', 'f_nacimiento', 'genero_id', 'nombre', 'apellido1', 'apellido2',
                'centroEducativo','domicilio', 'c_postal', 'localidad', 'provincia', 'nombreR1',
                'apellido1R1', 'apellido2R1', 'nombreR2', 'apellido1R2', 'apellido2R2', 'telefono',
                'telefonoFijo', 'telefonoOtro', 'email', 'obsEnfermedad', 'obsAlergia', 'obsOtras',
                'miembro_id', 'temporada_id', 'estado', 'f_preinscripcion', 'f_pago', 'importePago',
                'modalidad_cuotas',
                'nPreinscripcion', 'socio', 'autorizacion', 'normas', 'nRecibo', 'nomSerigrafia', 'dorsal'];

    public function genero(){
        return $this->belongsTo('BMLaguna\Genero');
    }

    public function miembro(){
        return $this->belongsTo('BMLaguna\Miembro');
    }

    public function temporada(){
        return $this->belongsTo('BMLaguna\Temporada');
    }

     public function categoriaCuota()
     {
         $temporada = $this->temporada_id
             ? Temporada::find($this->temporada_id)
             : Temporada::Tactual();

         if (is_null($temporada) || is_null($this->f_nacimiento)) {
             return new Categoria;
         }

         return Miembro::categoriaEdad($this->f_nacimiento, $temporada->temporada);
     }

     public function importePrimerPlazo($modalidad)
     {
         $categoria = $this->categoriaCuota();

         switch ((int) $modalidad) {
             case 2:
                 return $categoria->precio_2c1;
             case 3:
                 return $categoria->precio_3c1;
             default:
                 return $categoria->precio_inscripcion;
         }
     }

     public function cuota()
     {
         return $this->importePrimerPlazo(1);
     }

     /**
      * Plazos de pago según modalidad: importe, vencimiento y tipospago_id por cuota.
      *
      * @return array<int, array{importe: mixed, f_vencimiento: string|null, tipospago_id: int}>
      */
     public function plazosPago()
     {
         $categoria = $this->categoriaCuota();
         $modalidad = (int) $this->modalidad_cuotas;

         $datos = [
             1 => [
                 ['importe' => $categoria->precio_inscripcion, 'f_vencimiento' => $categoria->f_plazo_insc],
             ],
             2 => [
                 ['importe' => $categoria->precio_2c1, 'f_vencimiento' => $categoria->f_plazo_2c1],
                 ['importe' => $categoria->precio_2c2, 'f_vencimiento' => $categoria->f_plazo_2c2],
             ],
             3 => [
                 ['importe' => $categoria->precio_3c1, 'f_vencimiento' => $categoria->f_plazo_3c1],
                 ['importe' => $categoria->precio_3c2, 'f_vencimiento' => $categoria->f_plazo_3c2],
                 ['importe' => $categoria->precio_3c3, 'f_vencimiento' => $categoria->f_plazo_3c3],
             ],
         ];

         $plazos = $datos[$modalidad] ?? $datos[1];
         $tipos = Tipospago::tiposPorModalidad($modalidad ?: 1);

         if ($tipos->count() < count($plazos)) {
             throw new \RuntimeException(
                 'No hay tipos de pago configurados para la modalidad '.$modalidad
             );
         }

         foreach ($plazos as $i => $plazo) {
             $plazos[$i]['tipospago_id'] = $tipos[$i]->id;
             $plazos[$i]['f_vencimiento'] = $plazo['f_vencimiento'] ?: null;
         }

         return $plazos;
     }
}
