<?php

namespace App\Exports;

use App\Models\Vendedore;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsuariosExport implements FromCollection, WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Vendedore::all();
    }
    public function headings():array{
        return ["Id","Nombre","Dirección","Teléfono","","","Rol","Estado","Carnet","","Correo","Password","Ciudad"];
    }
}
