<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutoresCorrespondencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_autor';

    protected $fillable = [
        'nom_autor',
        'ap_autor',
        'am_autor',
        'correo',
        'tel',
    ];

    public function articulos()
    {
        return $this->hasMany('App\Models\Articulo', 'id_autor', 'id_autor');
    }
}
