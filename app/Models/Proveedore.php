<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedore extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['nombre','direccion','ciudad','contacto','telefono'];
}
