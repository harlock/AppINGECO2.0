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
    'id_mesa',
    'id_user',
  ];

  public function mesas()
  {
    return $this->hasOne('App\Models\Mesa', 'id_mesa', 'id_mesa');
  }
}
