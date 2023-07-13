<?php

namespace App\Exports;

use App\Models\A_lidere;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class ALidereExport implements FromCollection,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return A_lidere::all();
    }
    public function headings():array{
        return ["Id","Nombre","Regional","CI","Celular","Estado","Rol","Servidor"];
    }
}
