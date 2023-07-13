@extends(session("usr")->rol=="Vendedores"?"layouts.plantillasaldos":'') 
@section('contenido')
    <br>
    <div style="display: flex;justify-content:space-between">
        <div class="titulo">
            <h3>Detalle comisiones</h3>&nbsp;&nbsp;
            {{-- <div>de Fecha: <input type="text" id="fechax" onchange="cambiafecha(this)" autocomplete="off" style="border:0;background:lemonchiffon;text-align:center" value="{{implode("-",array_reverse(explode("-",$fecha)))}}" readonly></div> --}}
            
        </div>
    </div>

    <table class="table table-light " id="tb_detallecomisionvendedor">
        <thead class="thead-light">
            <tr>
                {{-- <th></th> --}}
                <th>N</th>
                <th>Descripcion</th>
                <th>Vendedor</th>
                <th>Dep</th>
                <th>Cliente</th>
                <th>Telf</th>
                <th>FechaVenta</th>
                <th>PrecioOrig</th>
                <th>PrecioFinal</th>
                {{-- <th>Comision</th> --}}
                <th>Cuantos</th>
                <th>SubTotal</th>
                <th>COMISIÓN</th>
                <th>PAGADO</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalle as $key=>$unprod)
                <tr>
                    {{-- <td><input type="checkbox" name="ch_{{$key+1}}" id="ch_{{$key+1}}" onchange="cambia(this)" checked></td> --}}
                    <td>{{$loop->iteration}}</td>
                    <td>{{$unprod->descripcion}}</td>
                    <td>{{$unprod->nombre}}</td>
                    <td>{{$unprod->idneg}}</td>
                    <td>{{$unprod->cliente}}</td>
                    <td>{{$unprod->telefono}}</td>
                    <td>{{implode("-",array_reverse(explode("-",explode(" ",$unprod->fecha)[0])))." ".explode(" ",$unprod->fecha)[1]}}</td>
                  
                    <td>{{$unprod->precioventa}}</td>
                    @if ($unprod->preciofinal<$unprod->precioventa)
                        <td style="color:orangered;font-weight:bold">{{$unprod->preciofinal}}</td>
                    @else 
                        <td>{{$unprod->preciofinal}}</td>
                    @endif
                    {{-- <td>{{$unprod->comision}}</td> --}}
                    <td>{{$unprod->cuantos}}</td>

                    @if ($unprod->preciofinal<$unprod->precioventa)
                        <td title="DIFERENCIA NEGATIVA {{$unprod->preciofinal*$unprod->cuantos - $unprod->precioventa*$unprod->cuantos}}">{{$unprod->cuantos * $unprod->preciofinal}}</td>
                    @else 
                        <td>{{$unprod->cuantos * $unprod->preciofinal}}</td>
                    @endif
                    <td>{{$unprod->cuantos * $unprod->comisfinal}}</td>
                    @if ($unprod->pagocomision!='')
                    <td>{{implode("-",array_reverse(explode("-",explode(" ",$unprod->pagocomision)[0])))." ".explode(" ",$unprod->pagocomision)[1]}}</td>
                    @else
                        <td></td>
                    @endif
                   
                </tr>
            @endforeach
            <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="font-weight:bold;font-size:1.5em">0</td><td></td></tr>
        </tbody>
    </table>

        {{-- <form action="{{route("ventas.ventasdetalladovendedor")}}" method="get" id="formufecha">
            @csrf
                <input type="hidden" name="fecha" id="fecha" class="form-control">
        </form> --}}
        
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>
    window.onload=function(){
        totaliza();
        tb=document.getElementById("tb_detallecomisionvendedor");
        nrofilas=tb.rows.length-1;
        total=0;
        $("#fechax").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat:"dd-mm-yy",
                        closeText: 'Cerrar',
                        prevText: '<Ant',
                        nextText: 'Sig>',
                        currentText: 'Hoy',
                        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                        weekHeader: 'Sm',
                        firstDay: 1,
                        isRTL: false,
                        showMonthAfterYear: false,
                        yearSuffix: ''
        });
    }

    function totaliza(){
        tb=document.getElementById("tb_detallecomisionvendedor");
        nrofilas=tb.rows.length-1;
        total=0;
        for(k=1;k<nrofilas;k++){
                if(tb.rows[k].cells[12].innerText!=''){
                    tb.rows[k].querySelectorAll("td").forEach(untd => {
                        untd.style="background:silver";
                    });
                }
                subtotal= parseFloat(tb.rows[k].cells[11].innerText);
                total=total + subtotal;
        }
        document.getElementById("total").innerText=total;
    }
    function cambiafecha(){
        document.getElementById("fecha").value=document.getElementById("fechax").value.split("-").reverse().join("-");
        document.getElementById("formcarnet").submit();
    }
    function irareporte(){
        console.log("entraareportevendedor");
        carnet=document.getElementById("carnet").value;
        if(carnet!=""){
            document.getElementById("elcarnet").value=carnet;
            document.getElementById("formcarnet").submit();
        }
        
    }
</script>
@endsection