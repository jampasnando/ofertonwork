<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedore extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['nombre','direccion','telefono','comision_ventas','comision_cobranzas','rol','estado','carnet','longitud','email','password','ciudad'];

}
