@extends(session("usr")->rol=="Enc. Tienda y caja"?"layouts.plantillavendedor":'layouts.plantillabase') 
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <br>
        <div style="display: flex;justify-content:space-between">
            <div class="titulo">
                <h3>Kardex de: <span style="color:orange;">{{$nombrecli}}</span> </h3>&nbsp;&nbsp;<button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalcobrar">Cobrar</button>               
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
                        if(substr($unreg->comentario,0,2)=="C-"){
                            $fondo="background:palegreen;";
                            $unreg->total=0;
                            $unreg->pago=0;
                            $unreg->saldo=$unreg->saldo * (-1);
                            $btn=false;
                        }
                        else{
                            $fondo="";
                            $btn=true;
                        }
                    @endphp
                    <tr ondblclick="edita({{json_encode($unreg->idventa)}})" >
                        <td style='{{$fondo}}'>{{$loop->iteration}}</td>
                        <td style='{{$fondo}}'>{{$fecha}}</td>
                        <td style='{{$fondo}}'>{{$unreg->nombre}}</td>
                        <td style='{{$fondo}}'>{{$unreg->comentario}}</td>
                        <td style='{{$fondo}}'>{{$unreg->formapago}}</td>
                        <td style='{{$fondo}}'>{{$unreg->total}}</td>
                        <td style='{{$fondo}}'>{{$unreg->pago}}</td>
                        <td style='{{$fondo}}'>{{$unreg->saldo}}</td>
                        @if ($btn)
                        <td><button class="btn btn-sm btn-warning" onclick="verventa('{{$unreg->idventa}}')">Ver</button></td>
                        @else
                            <td><button class="btn btn-sm btn-danger" onclick="eliminacobro('{{$unreg->idventa}}')">X</button></td>
                        @endif
                        
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
        {{-- ////////////////////////////////////////////////////////////// MODAL COBRAR /////////////////////////////////////////////////////////////////////// --}}
<div class="modal fade" id="modalcobrar" tabindex="-1" role="dialog" aria-labelledby="cobrarTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Cobrar</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="equiscli">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >*Monto</span>
                <input type="number" class="form-control" aria-label="Sizing example input" id="montocobro" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >Forma Pago</span>
                <select class="form-select" aria-label="Default select example" id="tipopago" >
                    <option value="contado">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="transferencia">QR</option>
                    <option value="cheque">Cheque</option>
                    <option value="deposito">Depósito</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>
           
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >Comentario</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="comentario" aria-describedby="inputGroup-sizing-sm" >
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" onclick="guardacobro()" id="btnguardarcli">Registrar Cobro</button>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" name="idcli" id="idcli" value='{{$idcli}}'>
  <input type="hidden" name="idusr" id="idusr" value="{{session("usr")->id}}">
{{-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

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
    function guardacobro(){
        dataenvio=[
                {
                    idcliente:document.getElementById("idcli").value,
                    cliente:'{{$nombrecli}}',
                    idusr:document.getElementById("idusr").value,
                    formapago:document.getElementById("tipopago").value,
                    comentario:document.getElementById("comentario").value,
                    monto:document.getElementById("montocobro").value,
                }
            ];
            if(parseFloat(document.getElementById("montocobro").value)>0){
                fetch('guardacobro', {
                method: 'post',
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": document.querySelector('input[name="_token"]').value
                },
                credentials: "same-origin",
                body: JSON.stringify(dataenvio)
                })
                .then(res => res.json())
                .then(res => {
                    console.log("desdeBD: ",res);
                    if(res){
                        window.location.reload();
                    }
                });
            }
            else{
                alert("Falta el MONTO");
            }
            
    }
    function eliminacobro(idcobro){
        if(confirm("ESTÁ SEGURO DE ELIMINAR ESTE COBRO ?")){
            dataenvio=[
                {
                    idcobro:idcobro
                }
            ];
                fetch('eliminacobro', {
                method: 'post',
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": document.querySelector('input[name="_token"]').value
                },
                credentials: "same-origin",
                body: JSON.stringify(dataenvio)
                })
                .then(res => res.json())
                .then(res => {
                    console.log("desdeBD: ",res);
                    if(res){
                        window.location.reload();
                    }
                });
        }
        
    }
</script>
@endsection