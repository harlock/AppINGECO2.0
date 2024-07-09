<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignaRevisores extends Model
{
    use HasFactory;
    protected $primaryKey="id_";

    protected $fillable =[
        'id_articulo',
        'id_user',
    ];

    public function arti(){
      //  dd("ok");
      return $this->hasOne('App\Models\Articulo','id_articulo','id_articulo')
      ->join("users",'users.id',"id_user")->first();
    }
    public function userRevis(){
        return $this->hasOne('App\Models\User','id','id_user');
    }
}
