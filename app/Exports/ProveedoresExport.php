<?php

namespace App\Exports;

use App\Models\Proveedore;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProveedoresExport implements FromCollection, WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Proveedore::all();
    }
    public function headings():array{
        return ["Id","Nombre","Dirección","Ciudad","Contacto","Telefono"];
    }
}
