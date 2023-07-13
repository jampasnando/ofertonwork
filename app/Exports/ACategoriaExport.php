<?php

namespace App\Exports;

use App\Models\A_categoria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutosize;
class ACategoriaExport implements FromCollection, WithHeadings,ShouldAutosize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return A_categoria::all();
    }
    public function headings():array{
        return ["Id","Categoria","IdSAP","Estado"];
    }
}
