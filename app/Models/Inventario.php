<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['idprod','descripcion','marca','cantidad','categoria','unidad','preciolocal','precioventa','comision','deposito','proveedor','imagenes'];
}
