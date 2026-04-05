<?php

namespace BMLaguna;

use Illuminate\Database\Eloquent\Model;

class InformeFisicoTecnicoTactico extends Model
{
    protected $table = 'informes_fisico_tecnico_tacticos';

    protected $fillable = [
        'miembro_id',
        'temporada_id',
        'categoria_id',
        'texto',
        'tecnico_id',
    ];

    public function miembro()
    {
        return $this->belongsTo(Miembro::class);
    }

    public function temporada()
    {
        return $this->belongsTo(Temporada::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Miembro (técnico de club) que redactó o firma el informe.
     */
    public function tecnico()
    {
        return $this->belongsTo(Miembro::class, 'tecnico_id');
    }
}
