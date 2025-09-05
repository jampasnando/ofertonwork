<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['idcliente','cliente','monto','formapago','comentario','fechareg','idusr'];
}
