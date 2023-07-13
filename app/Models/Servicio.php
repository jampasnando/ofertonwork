<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=['fechareg','codigo','estado','marca','ciudad','cliente','falla','receptor','fecharecepcion','estadoactual','entregadocliente','fechaentregados'];
}
