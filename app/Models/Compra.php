<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['idneg','idcompra','total','proveedor','nit','formapago','fecha','comentario','comprador','idusr','factura'];
}
