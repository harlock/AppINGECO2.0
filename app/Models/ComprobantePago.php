<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobantePago extends Model
{
    use HasFactory;

    protected $primaryKey = "id_articulo";

    protected $fillable = [
        'id_user',
        'id_articulo',
        'comprobante',
        'referencia',
        'factura',
        'constancia_fiscal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'id_articulo');
    }
}
