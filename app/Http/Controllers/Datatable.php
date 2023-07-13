<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
class Datatable extends Controller
{
    public function inventarioz(){
        $productos=Inventario::all();
        return datatables()->of($productos)->toJson();
    }
}
