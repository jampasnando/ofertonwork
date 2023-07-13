<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hist_traspaso extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['idprod','descripcion','marca','cantidad','preciolocal','precioventa','comision','deposito','depdestino','traspasado','fecha','usuario','observaciones'];
}
