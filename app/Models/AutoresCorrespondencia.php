<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutoresCorrespondencia extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'nom_autor',
        'ap_autor',
        'am_autor',
        'correo',
        'tel',
    ];
    protected $primaryKey = 'id_autor';

}
