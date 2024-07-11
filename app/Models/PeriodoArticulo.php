<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodoArticulo extends Model
{
    use HasFactory;

    protected $table = 'periodos_articulos';
    protected $primaryKey = 'id_periodo';
    protected $fillable = ['fecha_inicio', 'fecha_fin'];
}
