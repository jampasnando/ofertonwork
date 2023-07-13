<?php

namespace App\Exports;

use App\Models\Inventario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class InventarioExport implements FromCollection, WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventario::all();
    }
    public function headings():array{
        return ["Id","IdProd","Descripcion","Marca","Cantidad","Categoria","Unidad","PrecioLocal","PrecioVenta","Comision","Deposito","Proveedor"];
    }
}

