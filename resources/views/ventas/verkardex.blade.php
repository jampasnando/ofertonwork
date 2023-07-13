@extends(session("usr")->rol=="Enc. Tienda y caja"?"layouts.plantillavendedor":'layouts.plantillabase') 
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <br>
        <div style="display: flex;justify-content:space-between">
            <div class="titulo">
                <h3>Kardex de: <span style="color:orange;">{{$nombrecli}}</span> </h3>&nbsp;&nbsp;               
            </div>
        </div>

        <table class="table table-light " id="tb_vtasdetallada">
            <thead class="thead-light">
                <tr>
                    {{-- <th></th> --}}
                    <th>N</th>
                    <th>Fecha</th>
                    <th>Registrador</th>
                    <th>Comentario</th>
                    <th>Formapago</th>
                    <th>Total</th>
                    <th>Pago</th>
                    <th>Saldo</th>
                    <th></th>
                    {{-- <th>ComisionTotal</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $key=>$unreg)
                    @php
                        $fecha=implode("-",array_reverse(explode("-",explode(" ",$unreg->fecha)[0])))." ".explode(" ",$unreg->fecha)[1];
                    @endphp
                    <tr ondblclick="edita({{json_encode($unreg->idventa)}})">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$fecha}}</td>
                        <td>{{$unreg->nombre}}</td>
                        <td>{{$unreg->comentario}}</td>
                        <td>{{$unreg->formapago}}</td>
                        <td>{{$unreg->total}}</td>
                        <td>{{$unreg->pago}}</td>
                        <td>{{$unreg->saldo}}</td>
                        <td><button class="btn btn-sm btn-warning" onclick="verventa('{{$unreg->idventa}}')">Ver</button></td>
                    </tr>
                @endforeach
                <tr>
                    <td></td><td></td><td></td><td></td><td></td><td id="total"></td><td id="pago"></td><td id="saldo"></td><td></td>
                </tr>
                {{-- <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="font-weight:bold;font-size:1.5em">0</td></tr> --}}
            </tbody>
        </table>
        <table>
            <tr>
                <td></td><td></td><td></td><td></td><td></td><td id="total"></td><td id="pago"></td><td id="saldo"></td><td></td>
            </tr>
        </table>
        <form action="{{route('ventas.editaventa')}}" method="post" id="formuveventa">
            @csrf
            <input type="hidden" name="idventa" id="idventa">
        </form>
@endsection
<style>
    #tb_vtasdetallada tr:last-child td{
        background:lightgray;
        font-weight: bold;
    }
</style>
@section('js')

{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script> --}}

<script>
    window.onload=function(){
        tb=document.getElementById("tb_vtasdetallada");
        filas=tb.rows.length-1;
        total=0;
        pago=0;
        saldo=0;
        for(k=1;k<filas;k++){
            total+=tb.rows[k].cells[5].innerText*1;
            pago+=tb.rows[k].cells[6].innerText*1;
            saldo+=tb.rows[k].cells[7].innerText*1;
        }
        console.log(total,pago,saldo);
        document.getElementById("total").innerText=total;
        document.getElementById("pago").innerText=pago;
        document.getElementById("saldo").innerText=saldo;
    }
    dataenvio=[];
    function verventa(idventa){
        document.getElementById("idventa").value=idventa;
        document.getElementById("formuveventa").submit();
    }
</script>
@endsection