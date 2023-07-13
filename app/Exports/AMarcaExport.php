<?php

namespace App\Exports;

use App\Models\A_marca;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class AMarcaExport implements FromCollection,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return A_marca::all();
    }
    public function headings():array{
        return ["Id","Categoria","Nombre","Estado"];
    }
}
