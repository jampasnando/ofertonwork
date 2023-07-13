<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallecompra extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['idcompra','idprod','descripcion','preciolocal','cuantos','registrado'];

}
