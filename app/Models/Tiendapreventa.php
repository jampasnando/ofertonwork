<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiendapreventa extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['json','cliente','celular','metodopago','deposito','origen','fecha_creacion','estado'];

}
