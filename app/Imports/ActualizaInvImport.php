<?php

namespace App\Imports;

use App\Models\Inventario;
use Maatwebsite\Excel\Concerns\ToModel;

class ActualizaInvImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $prods=Inventario::where("idprod",$row[0])->get();
        foreach ($prods as $prod ) {
            if($row[1]!=""){
                $prod->cantidad=$row[1];
            }
            if($row[2]!=""){
                $prod->preciolocal=$row[2];
            }
            if($row[3]!=""){
                $prod->precioventa=$row[3];
            }
            if($row[4]!=""){
                $prod->comision=$row[4];
            }
            $prod->save();
        }
    }
}
