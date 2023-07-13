@extends(session("usr")->rol=="Enc. Tienda y caja"?"layouts.plantillavendedor":'layouts.plantillabase') 
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <br>
        <div style="display: flex;justify-content:space-between">
            <div class="titulo">
                <h3>Detalle Compra</h3>&nbsp;&nbsp;
                {{-- <div>de Fecha: <input type="text" id="fechax" onchange="cambiafecha(this)" autocomplete="off" style="border:0;background:lemonchiffon;text-align:center" value="{{implode("-",array_reverse(explode("-",$fecha)))}}" readonly></div> --}}
                
            </div>
            {{-- <a href="{{route("ventas.paracerrarcaja")}}" class="btn btn-warning">Ir a cierre de caja</a> --}}
        </div>
        {{-- <div class="totalesventadeldia">
            <div id="totaltotal">Total: <span></span></div>
            <div id="contado">Contado: <span></span></div>
            <div id="tarjeta">Tarjeta: <span></span></div>
            <div id="cheque">Cheque: <span></span></div>
            <div id="deposito">Depósito: <span></span></div>
            <div id="transferencia">Transferencia: <span></span></div>
        </div>   --}}
        <div class="input-group mb-3" id="divcredito">
            <table style="width: 100%">
                <tr>
                    <td>
                      <span class="input-group-text" id="inputGroup-sizing-sm">Fecha</span>
                      <input type="text" readonly class="form-control bg-light" id="fecha" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="{{$compra->fecha}}">
                    </td>
                    <td>
                      <span class="input-group-text" id="inputGroup-sizing-sm">Depósito</span>
                      <input type="text" readonly class="form-control bg-light" id="idneg" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="{{$compra->idneg}}">
                    </td>
                    <td>
                      <span class="input-group-text" id="inputGroup-sizing-sm">Proveedor</span>
                      <input type="text" readonly class="form-control bg-light" id="proveedorx" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="{{$compra->proveedor}}">
                    </td>
                    <td>
                        <span class="input-group-text" id="inputGroup-sizing-sm">Factura</span>
                        <input type="text" readonly class="form-control bg-light" id="factura" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="{{$compra->factura}}">
                    </td>
                    <td>
                        <span class="input-group-text" id="inputGroup-sizing-sm">FormaPago</span>
                        <input type="text" readonly class="form-control bg-light" id="formapago" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="{{$compra->formapago}}">
                      </td>
                </tr>
            </table>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Comentario</span>
                <input type="text" readonly class="form-control bg-light" id="comentario" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="{{$compra->comentario}}">
            </div>
            
       
      </div>
        <table class="table" id="tb_detallecompras">
            <thead class="thead-light">
                <tr>
                    <th>N</th>
                    <th>IdProd</th>
                    <th>Descripcion</th>
                    <th>PrecioCompra</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detalle as $key=>$unprod)
                    <tr >
                        <td>{{$loop->iteration}} <input type="hidden" name="id_{{$loop->iteration}}" id="id_{{$loop->iteration}}" value="{{$unprod->id}}"></td>
                        <td>{{$unprod->idprod}}</td>
                        <td>{{$unprod->descripcion}}</td>
                        <td>{{$unprod->preciolocal}}</td>
                        <td>{{$unprod->cuantos}}</td>
                        {{-- <td>{{implode("-",array_reverse(explode("-",explode(" ",$unprod->fecha)[0])))." ".explode(" ",$unprod->fecha)[1]}}</td> --}}
                        {{-- <td>{{$unprod->formapago}}</td> --}}
                        <td>{{$unprod->cuantos * $unprod->preciolocal}}</td>
                       
                        
                    </tr>
                @endforeach
                <tr><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.2em">Sub Total: </td><td id="total" style="font-weight:bold;font-size:1.2em">0</td></tr>
                <tr><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em" >Total: </td><td style="font-weight:bold;font-size:1.5em" id="totalgral">{{$compra->total}}</td></tr>
            </tbody>
        </table>
        <div style="background: aliceblue;display:none" id="divceleste">
            <div class="titulo">Pagos:</div>
            <div class="input-group mb-3" id="divcredito" >
                <table id="tpagos">
                    <tr>
                        <th> <span class="input-group-text" id="inputGroup-sizing-sm">Pagado</span></th>
                        <th> <span class="input-group-text" id="inputGroup-sizing-sm">Fecha</span></th>
                        <th> <span class="input-group-text" id="inputGroup-sizing-sm">TipoPago</span></th>
                        <th> <span class="input-group-text" id="inputGroup-sizing-sm">Observacion</span></th>    
                    </tr>
                    @foreach ($pagos as $pago)
                        <tr>
                            <td>
                                <input type="number" class="form-control bg-light" readonly id="monto" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="{{$pago->monto}}">
                            </td>
                            <td>
                                <input type="text" class="form-control bg-light" readonly id="fechapago" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="{{$pago->fecha}}">
                            </td>
                            <td>
                                <input type="text" class="form-control bg-light" readonly id="tipopagado" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="{{$pago->tipopago}}">
                            </td>
                            <td style="background: snow">
                               {{$pago->observacion}}
                            </td>
                        </tr>
                    @endforeach
                    
                </table>
                
          </div>
          <br>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Pendiente por pagar:</span>
            <input type="text" readonly class="form-control bg-light" id="pendiente" style="font-weight: bolder;color:tomato;font-size:1.5em">
        </div>
        <div><button class="btn btn-secondary" onclick="nuevopago()">Nuevo Pago</button></div>
        <form action="{{route("compras.registrapago")}}" method="post" id="formupago">
            @csrf
        <div class="input-group mb-3" style="display: none;justify-content:center" id="nuevopago">
            
                <table>
                    <tr>
                        <th>Monto</th>
                        {{-- <th>Fecha</th> --}}
                        <th>TipoPago</th>
                        <th>Observacion</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="number" class="form-control bg-light" id="monto" name="monto" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </td>
                        {{-- <td>
                            <input type="text" class="form-control bg-light" id="fecha" name="fecha" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </td> --}}
                        <td>
                            <select class="form-select" aria-label="Default select example" id="tipopago" name="tipopago" >
                                <option value="contado">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="cheque">Cheque</option>
                                <option value="deposito">Depósito</option>
                                <option value="transferencia">Transferencia</option>
                            </select>
                        </td>
                        <td style="background: snow">
                            <input type="text" class="form-control bg-light" id="observacion" name="observacion" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </td>
                        <td><button class="btn btn-secondary" type="submit">Registrar nuevo pago</button></td>
                    </tr>
                </table>
                <input type="hidden" name="idcompra" name="idcompra" value="{{$compra->idcompra}}">
                <input type="hidden" name="id" name="id" value="{{$compra->id}}">
                <input type="hidden" name="proveedor" value="{{$compra->proveedor}}}">
        </div>
        </form>
        
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>
    window.onload=function(){
        totaliza();
        if(document.getElementById("formapago").value=="credito"){
            document.getElementById("divceleste").style.display="block";
            tpagos=document.getElementById("tpagos");
            tpagado=0;
            for(j=1;j<tpagos.rows.length;j++){
                tpagado+=parseFloat(tpagos.rows[j].cells[0].querySelector("input").value);
            }
            document.getElementById("pendiente").value=parseFloat(document.getElementById("totalgral").innerText) - tpagado;
            console.log("pagado: ",tpagado);
        }
       
        // tb=document.getElementById("tb_detallecompras");
        // nrofilas=tb.rows.length-1;
        // total=0;
        // for(k=1;k<nrofilas;k++){
        //     if(tb.rows[k].cells[6].innerText!=""){
        //         tb.rows[k].className="coloreagris";
        //     }
        //     else{
        //         tb.rows[k].className="coloreayellow";
        //     }
        // }
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
        tb=document.getElementById("tb_detallecompras");
        nrofilas=tb.rows.length-1;
        total=0;
        var totaliza=0;              
        var tcontado = 0;
        var ttarjeta = 0;
        var tcheque = 0;
        var tdeposito = 0;
        var ttransferencia=0;
        for(k=1;k<nrofilas;k++){
                subtotal= parseFloat(tb.rows[k].cells[5].innerText);
                total=total + subtotal;
        }
        document.getElementById("total").innerText=total;
    }
    function cambiafecha(){
        document.getElementById("fecha").value=document.getElementById("fechax").value.split("-").reverse().join("-");
        document.getElementById("formufecha").submit();
    }
    function nuevopago(){
        document.getElementById("nuevopago").style.display="flex";
    }
    function registranuevopago(){

    }
</script>
@endsection