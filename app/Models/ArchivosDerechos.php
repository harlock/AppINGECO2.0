<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivosDerechos extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_derecho';

    protected $fillable = [
        'id_articulo',
        'archivo_derecho',
        'estado',
        'mensaje',
    ];

    public function articulo()
    {
        return $this->belongsTo('App\Models\Articulo', 'id_articulo', 'id_articulo');
    }
}
