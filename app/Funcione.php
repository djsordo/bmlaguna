<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;
use BMLaguna\Miembro;
use BMLaguna\Equipo;

class Funcione extends Model
{
    const DESC_ENTRENADOR = 'entrenador';
    const DESC_DELEGADO = 'delegado';
    const DESC_PRIMER_ENTRENADOR = 'primer entrenador';
    const DESC_SEGUNDO_ENTRENADOR = 'segundo entrenador';
    const DESC_TECNICO = 'tecnico';

    /**
     * Funciones de club en ficha de miembro (checkboxes, no excluyentes entre sí).
     *
     * @return array
     */
    public static function descripcionesFuncionesMiembroClub()
    {
        return ['familiar', 'jugador', self::DESC_TECNICO];
    }

    /**
     * Roles de club que habilitan a un miembro como técnico en el modal de equipo.
     *
     * @return array
     */
    public static function rolesTecnicoClub()
    {
        return [self::DESC_DELEGADO, self::DESC_PRIMER_ENTRENADOR, self::DESC_SEGUNDO_ENTRENADOR];
    }

    /**
     * Roles que cuentan como oficial de equipo (incluye entrenador histórico en BD).
     *
     * @return array
     */
    public static function rolesOficialEquipo()
    {
        return array_merge(self::rolesTecnicoClub(), [self::DESC_ENTRENADOR]);
    }

    /**
     * Slug de URL → descripción en tabla funciones.
     *
     * @param  string  $slug
     * @return string
     */
    public static function slugADescripcion($slug)
    {
        $map = [
            'primer-entrenador' => self::DESC_PRIMER_ENTRENADOR,
            'segundo-entrenador' => self::DESC_SEGUNDO_ENTRENADOR,
            'delegado' => self::DESC_DELEGADO,
            'entrenador' => self::DESC_ENTRENADOR,
        ];
        if (isset($map[$slug])) {
            return $map[$slug];
        }

        return str_replace('-', ' ', $slug);
    }

    /**
     * Descripción en BD → segmento de URL seguro.
     *
     * @param  string  $descripcion
     * @return string
     */
    public static function descripcionASlug($descripcion)
    {
        $map = [
            self::DESC_PRIMER_ENTRENADOR => 'primer-entrenador',
            self::DESC_SEGUNDO_ENTRENADOR => 'segundo-entrenador',
            self::DESC_DELEGADO => 'delegado',
            self::DESC_ENTRENADOR => 'entrenador',
        ];
        if (isset($map[$descripcion])) {
            return $map[$descripcion];
        }

        return str_replace(' ', '-', $descripcion);
    }

    public function miembros(){
        return $this->belongsToMany('BMLaguna\Miembro', 'equipo_funcione_miembro')->withPivot('equipo_id');
    }

    public function equipos(){
        return $this->belongsToMany('BMLaguna\Equipo', 'equipo_funcione_miembro')->withPivot('miembro_id');
    }

}
