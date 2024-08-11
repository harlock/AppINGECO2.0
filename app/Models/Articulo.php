<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    protected $primaryKey = "id_articulo";

    protected $fillable = [
        'revista',
        'titulo',
        'estado',
        'modalidad',
        'archivo',
        'archivo_plagio',
        'id_mesa',
        'id_user',
        // Añadir 'id_autor' para la relación
        'id_autor',
    ];

    public function mesas()
    {
        return $this->hasOne('App\Models\Mesa', 'id_mesa', 'id_mesa');
    }

    public function autorCorrespondencia()
    {
        return $this->belongsTo('App\Models\AutoresCorrespondencia', 'id_autor', 'id_autor');
    }
}