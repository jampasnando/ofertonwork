<?php

namespace App\Exports;

use App\Venta;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class VentasRangofechas implements FromCollection,WithHeadings,ShouldAutoSize,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $fechaini;
    protected $fechafin;

    function __construct($fechaini,$fechafin) {
            $this->fechaini = implode("-",array_reverse(explode("-",$fechaini)));
            $this->fechafin = implode("-",array_reverse(explode("-",$fechafin)));
    }
    public function collection()
    {
        // $resultado=DB::select("select tb2.descripcion,tb2.nombre,vendedores.nombre as vendedor,tb2.cliente,tb2.fecha,tb2.cierre,tb2.cuantos,tb2.preciolocal,tb2.precioventa,tb2.preciofinal,tb2.comision as comisionUnit,(tb2.comision * tb2.cuantos) as ComisionTotal,tb2.total,round(tb2.total - (tb2.comision * tb2.cuantos) - tb2.preciolocal,2) as Utilidad from (select tb1.*,depositos.nombre from (select descripcion,idneg,detalleventas.vendedor,cliente,fecha,cierre,cuantos,preciolocal,precioventa,preciofinal,comision,cuantos*preciofinal as total from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa) as tb1 inner join depositos on tb1.idneg=depositos.id) as tb2 inner join vendedores on tb2.vendedor=vendedores.id");
        $resultado=DB::select("select  inventarios.idprod as codprod,tbf.*,inventarios.marca,inventarios.proveedor from (select tb2.descripcion,tb2.idprod,tb2.nombre,vendedores.nombre as vendedor,tb2.cliente,date(tb2.fecha) as fechav,date(tb2.cierre),tb2.cuantos,tb2.preciolocal,tb2.precioventa,tb2.preciofinal,tb2.comision as comisionUnit,(tb2.comision * tb2.cuantos) as ComisionTotal,tb2.total,round(tb2.total - (tb2.comision * tb2.cuantos) - tb2.preciolocal,2) as Utilidad from (select tb1.*,depositos.nombre from (select descripcion,idneg,detalleventas.vendedor,cliente,fecha,cierre,cuantos,preciolocal,precioventa,preciofinal,comision,cuantos*preciofinal as total,idprod from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa) as tb1 inner join depositos on tb1.idneg=depositos.id) as tb2 inner join vendedores on tb2.vendedor=vendedores.id) as tbf inner join inventarios on tbf.idprod=inventarios.id where fechav between '$this->fechaini' and '$this->fechafin'");
        return collect($resultado);
    }
    public function title():string{
        $hoy=date("d-m-Y");
        return "Ventas_".$this->fechaini."__".$this->fechafin;
    }
    public function headings():array{
        return [
            ["IdProd","Descripcion","ID","Depósito","Vendedor","Cliente","FechaVenta","FechaCierre","Cantidad","PrecioLocal","PrecioVenta","PrecioFinal","comisiónUnit","ComisiónTotal","Total","Utilidad","Marca","Proveedor"]
        ];
    }
}
