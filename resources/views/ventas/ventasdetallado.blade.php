@extends(session("usr")->rol=="Enc. Tienda y caja"?"layouts.plantillavendedor":'layouts.plantillabaseservicios') 
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <br>
        <div style="display: flex;justify-content:space-between">
            <div class="titulo">
                <h3>Ventas con detalle</h3>&nbsp;&nbsp;
                <div>de Fecha: <input type="text" id="fechax" onchange="cambiafecha(this)" autocomplete="off" style="border:0;background:lemonchiffon;text-align:center" value="{{implode("-",array_reverse(explode("-",$fecha)))}}" readonly></div>
                
            </div>
            <div>
                @if (session("usr")->rol!="Enc. Tienda y caja")
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#mimodal" id="btnmodal">
                    Exportar a Excel
                  </button>
                @endif
                <a href="{{route("ventas.paracerrarcaja")}}" class="btn btn-warning">Ir a cierre de caja</a>
            </div>
            
        </div>
{{-- ///////////////////////////////////////////////////////////////////////////////// --}}
        <div class="modal fade" tabindex="-1" id="mimodal">
            <div class="modal-dialog modal-dialog-centered ">
              <div class="modal-content">
                <div class="modal-header">
                    
                  <h5 class="modal-title">
                      <div id="desc"></div>
                     
                    </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="prov"></div>
                    <form action="{{route("exportarporfechas")}}" method="post" id="formuexp">
                        @csrf
                       <div class="mb-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm" >Fecha Inicio</span>
                                <input type="text" class="form-control"  id="fechaini" name="fechaini"  readonly style="border:0;background:lemonchiffon;text-align:center" title="REQUERIDO" autocomplete="off">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm" >Fecha Fin</span>
                                <input type="text" class="form-control"  id="fechafin" name="fechafin"  readonly style="border:0;background:lemonchiffon;text-align:center" title="REQUERIDO" autocomplete="off">
                            </div>
                        </div>
                        {{--<div class="mb-3">
                            <label for="cliente" class="form-label">Cliente</label>
                            <input type="text" class="form-control" id="cliente" name="cliente">
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono">
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                  {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> --}}
                  <button type="button" class="btn btn-primary" onclick="document.getElementById('formuexp').submit();">Exportar</button>
                </div>
              </div>
            </div>
        </div>
        
        {{-- //////////////////////////////////////////////////////////////////////////////////////// --}}

        <div class="totalesventadeldia">
            @php
                    $tefectivo=0;
                    $ttarjeta=0;
                    $tcheque=0;
                    $tdeposito=0;
                    $ttransferencia=0;
                    $tqr=0;
                    $tcredito=0;
                    $ttotal=0;
                    $fechareg="";
                    foreach ($detalle as $key=>$unprod){
                        $ttotal+=$unprod->cuantos * $unprod->preciofinal;
                        if($fechareg!=$unprod->fecha){
                            $fechareg=$unprod->fecha;
                            
                            if($unprod->formapago!="mixto"){
                                switch ($unprod->formapago) {
                                    case 'efectivo':
                                    $tefectivo+=$unprod->pago;
                                    break;
                                    case 'tarjeta':
                                    $ttarjeta+=$unprod->pago;
                                    break;
                                    case 'cheque':
                                    $tcheque+=$unprod->pago;
                                    break;
                                    case 'deposito':
                                    $tdeposito+=$unprod->pago;
                                    break;
                                    case 'transferencia':
                                    $ttransferencia+=$unprod->pago;
                                    break;
                                    case 'qr':
                                    $tqr+=$unprod->pago;
                                    break;
                                    case 'credito':
                                    $tcredito+=$unprod->saldo;
                                    break;
                                }
                            }
                            else{
                                $partesmixto="";
                                $aux=json_decode($unprod->pagomixto);
                                foreach ($aux as $key => $value) {
                                    switch ($key) {
                                        case 'efectivo':
                                        $tefectivo+=$value;
                                        break;
                                        case 'tarjeta':
                                        $ttarjeta+=$value;
                                        break;
                                        case 'cheque':
                                        $tcheque+=$value;
                                        break;
                                        case 'deposito':
                                        $tdeposito+=$value;
                                        break;
                                        case 'transferencia':
                                        $ttransferencia+=$value;
                                        break;
                                        case 'qr':
                                        $tqr+=$value;
                                        break;
                                        case 'credito':
                                        $tcredito+=$value;
                                        break;
                                    }
                                }
                            }
                        }
                       
                    }
            @endphp
            <div id="totaltotal">Total: {{$ttotal}} <span></span></div>
            <div id="credito" style="color:red;">Crédito: {{$tcredito}}<span></span></div>
            <div id="contado">Efectivo: {{$tefectivo}}<span></span></div>
            <div id="tarjeta">Tarjeta: {{$ttarjeta}}<span></span></div>
            <div id="cheque">Cheque: {{$tcheque}}<span></span></div>
            <div id="deposito">Depósito: {{$tdeposito}}<span></span></div>
            <div id="transferencia">Transferencia: {{$ttransferencia}}<span></span></div>
            <div id="transferencia">QR: {{$tqr}}<span></span></div>
            
            {{-- <div id="credito">Mixto: {{$partesmixto}}<span></span></div> --}}
        </div>  

        <table class="table table-light " id="tb_vtasdetallada">
            <thead class="thead-light">
                <tr>
                    {{-- <th></th> --}}
                    <th>N</th>
                    <th>IdProd</th>
                    <th>Descripcion</th>
                    <th>Proveedor</th>
                    <th>Vendedor</th>
                    <th>Dep</th>
                    <th>Cliente</th>
                    <th>Telf</th>
                    <th>FechaVenta</th>
                    <th>FormaPago</th>
                    <th>FechaCierre</th>
                    <th>PV</th>
                    {{-- <th>Dif</th> --}}
                    <th>Cuantos</th>
                    <th>PrecioFinal</th>
                    <th style="text-align: right">Total</th>
                    {{-- <th>Pago</th>
                    <th>Saldo</th> --}}
                </tr>
            </thead>
            <tbody>
                
                @foreach ($detalle as $key=>$unprod)
                    @if (session("usr")->rol=="Administradores")
                    <tr ondblclick="edita({{json_encode($unprod->idventa)}})">
                    @else
                    <tr>
                    @endif

                   
                        {{-- <td><input type="checkbox" name="ch_{{$key+1}}" id="ch_{{$key+1}}" onchange="cambia(this)" checked></td> --}}
                        <td>{{$loop->iteration}}</td>
                        <td>{{$unprod->idprod}}</td>
                        <td>{{$unprod->descripcion}}</td>
                        <td>{{$unprod->proveedor}}</td>
                        <td>{{$unprod->nombre}}</td>
                        <td>{{$unprod->idneg}}</td>
                        <td>{{$unprod->cliente}}</td>
                        <td>{{$unprod->telefono}}</td>
                        <td>{{implode("-",array_reverse(explode("-",explode(" ",$unprod->fecha)[0])))." ".explode(" ",$unprod->fecha)[1]}}</td>
                        <td title="{{$unprod->pagomixto}}">{{$unprod->formapago}}</td>
                        @if (!is_null($unprod->cierre))
                            <td>{{implode("-",array_reverse(explode("-",explode(" ",$unprod->cierre)[0])))." ".explode(" ",$unprod->cierre)[1]}}</td>
                        @else
                            <td></td>
                        @endif
                        <td>{{$unprod->precioventa}}</td>
                        <td>{{$unprod->cuantos}}</td>
                        @if ($unprod->preciofinal<$unprod->precioventa)
                            <td style="color:orangered;font-weight:bold">{{$unprod->preciofinal}}</td>
                            <td title="DIFERENCIA NEGATIVA {{$unprod->preciofinal*$unprod->cuantos - $unprod->precioventa*$unprod->cuantos}}">{{$unprod->cuantos * $unprod->preciofinal}}</td>
                        @else 
                            <td>{{$unprod->preciofinal}}</td>
                            <td>{{$unprod->cuantos * $unprod->preciofinal}}</td>
                        @endif
                        {{-- <td>{{$unprod->pago}}</td>
                        <td>{{$unprod->saldo}}</td> --}}
                        {{-- <td title="{{}}">{{$unprod->cuantos * $unprod->preciofinal}}</td> --}}
                       
                        
                    </tr>
                @endforeach
                <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Totales: </td>
                    {{-- <td id="totalx" style="font-weight:bold;font-size:1.5em;border:1px solid silver;">0</td> --}}
                    <td id="total" style="font-weight:bold;font-size:1.5em;border:1px solid silver;">0</td>
                    {{-- <td id="tsaldo" style="font-weight:bold;font-size:1.5em;border:1px solid silver;">0</td> --}}
                </tr>
            </tbody>
        </table>
        <form action="{{route("ventas.detallev")}}" method="get" id="formufecha">
            @csrf
                <input type="hidden" name="fecha" id="fecha" class="form-control">
        </form>
        <form action="{{route("ventas.editaventa")}}" method="post" id="formuedit">
            @csrf
                <input type="hidden" name="idventa" id="idventa" class="form-control">
        </form>
        
@endsection
<style>
    .modal-open .ui-datepicker{z-index: 2000!important}
</style>
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>
    window.onload=function(){
        totaliza();
        tb=document.getElementById("tb_vtasdetallada");
        nrofilas=tb.rows.length-1;
        total=0;
        for(k=1;k<nrofilas;k++){
            if(tb.rows[k].cells[10].innerText!=""){
                tb.rows[k].className="coloreagris";
            }
            else{
                tb.rows[k].className="coloreayellow";
            }
           
        }
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
        $("#fechaini").datepicker({
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
        $("#fechafin").datepicker({
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

    // function cambia(chk){
    //     console.log(chk.checked);
    //     color="";
    //     if(chk.checked){
    //         color="lightyellow";
    //     }
    //     else{
    //         color="snow";
    //     }
    //     chk.parentElement.style.background="red";
    //     celdas=chk.parentElement.parentElement.querySelectorAll("td");
    //     for(i=0;i<celdas.length;i++){
    //         celdas[i].style.background=color;
    //     }
    //     totaliza();
    // }
    function totaliza(){
        tb=document.getElementById("tb_vtasdetallada");
        nrofilas=tb.rows.length-1;
        total=0;
        // totalx=0;
        // var totalizax=0;
        // var totaliza=0;              
        // var tcontado = 0;
        // var ttarjeta = 0;
        // var tcheque = 0;
        // var tdeposito = 0;
        // var ttransferencia=0;
        // var tcredito=0;
        for(k=1;k<nrofilas;k++){
                subtotal= parseFloat(tb.rows[k].cells[14].innerText);
                total=total + subtotal;
                // formapago=tb.rows[k].cells[9].innerText;
                //     switch (formapago) {
                //         case "contado":
                //                 tcontado+=parseFloat(subtotal);
                //         break;
                //         case "tarjeta":
                //             ttarjeta+=parseFloat(subtotal);
                //         break;
                //         case "cheque":
                //             tcheque+=parseFloat(subtotal);
                //         break;
                //         case "deposito":
                //             tdeposito+=parseFloat(subtotal);
                //         break;
                //         case "transferencia":
                //             ttransferencia+=parseFloat(subtotal);
                //         break;
                //     }
                //     totaliza += parseFloat(subtotal);
               
                console.log("totaliza:",totaliza);
        }
        document.getElementById("total").innerText=total;
        // document.getElementById("totaltotal").querySelector("span").innerText=totaliza;
        // document.getElementById("contado").querySelector("span").innerText=tcontado;
        // document.getElementById("tarjeta").querySelector("span").innerText=ttarjeta;
        // document.getElementById("cheque").querySelector("span").innerText=tcheque;
        // document.getElementById("deposito").querySelector("span").innerText=tdeposito;
        // document.getElementById("transferencia").querySelector("span").innerText=ttransferencia;
        // document.getElementById("credito").querySelector("span").innerText=tcredito;
    }
    function cambiafecha(){
        document.getElementById("fecha").value=document.getElementById("fechax").value.split("-").reverse().join("-");
        document.getElementById("formufecha").submit();
    }
    function edita(idventa){
        console.log(idventa);
        document.getElementById("idventa").value=idventa;
        document.getElementById("formuedit").submit();  
        // document.getElementById("desc").innerText=unprod.descripcion + " | $" + unprod.precioventa;
        // document.getElementById("prov").innerText=unprod.proveedor;
        // document.getElementById("btnmodal").click();
        
    }
</script>
@endsection