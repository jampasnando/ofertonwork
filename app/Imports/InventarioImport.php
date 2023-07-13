<?php

namespace App\Imports;

use App\Models\Inventario;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InventarioImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Inventario([
            "idprod"=>$row["idprod"],
            "descripcion"=>$row["descripcion"],
            "marca"=>$row["marca"],
            "cantidad"=>$row["cantidad"],
            "categoria"=>$row["categoria"],
            "unidad"=>$row["unidad"],
            "preciolocal"=>$row["preciolocal"],
            "precioventa"=>$row["precioventa"],
            "comision"=>$row["comision"],
            "deposito"=>$row["deposito"],
            "proveedor"=>$row["proveedor"],
            "imagenes"=>""
        ]);
    }
}
