<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['idneg','idventa','total','cliente','telefono','nit','formapago','fecha','comentario','vendedor','idusr','idcliente','pago','saldo','pagomixto'];
}
