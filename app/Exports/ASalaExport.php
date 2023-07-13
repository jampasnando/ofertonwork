<?php

namespace App\Exports;

use App\Models\A_sala;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutosize;
class ASalaExport implements FromCollection, WithHeadings,ShouldAutosize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return A_sala::all();
    }
    public function headings():array{
        return [
            "Id","Nombre","Ciudad","Latitud","Longitud","Cliente","Estado"
        ];
    }
}
