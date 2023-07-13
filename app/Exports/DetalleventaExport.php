<?php

namespace App\Exports;

use App\Models\Detalleventa;
use App\Models\Venta;
use DB;
// use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
// use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DetalleventaExport implements FromCollection,WithHeadings,ShouldAutoSize,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $fechacierre;

    function __construct($fechacierre) {
            $this->fechacierre = $fechacierre;
    }
    public function collection()
    {
        // return Detalleventa::all();
        // $result= DB::select("select descripcion,cliente,fecha,cierre,cuantos,preciofinal,cuantos*preciofinal as total from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa where cierre='$this->fechacierre'");
        $result= DB::select("select tb2.descripcion,tb2.nombre,vendedores.nombre as vendedor,tb2.cliente,tb2.fecha,tb2.cierre,tb2.cuantos,tb2.preciofinal,tb2.total from (select tb1.*,depositos.nombre from (select descripcion,idneg,detalleventas.vendedor,cliente,fecha,cierre,cuantos,preciofinal,cuantos*preciofinal as total from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa where cierre='$this->fechacierre') as tb1 inner join depositos on tb1.idneg=depositos.id) as tb2 inner join vendedores on tb2.vendedor=vendedores.id");
        return collect($result);
    }
    public function title():string{
        return "Detalle Cierre de Ventas";
    }
    public function headings():array{
        return [
            // ["Detalle Cierre Caja"],
            ["Descripcion","Sucursal","Vendedor","Cliente","FechaVenta","FechaCierre","Cuantos","PrecioVenta","Total"]
        
        ];
    }
    // public function registerEvents(): array
    // {
    //     return [
    //            AfterSheet::class=> function(AfterSheet $event) {
    //                $event->sheet->appendRow(array([
    //                    "dato"=>"eldato"
    //                ]),$event);
    //      },
    //     ];
    // }
}
