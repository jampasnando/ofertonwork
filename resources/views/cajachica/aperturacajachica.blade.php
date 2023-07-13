@extends(session("usr")->rol=="Enc. Tienda y caja"?"layouts.plantillavendedor":'layouts.plantillabase') 
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <br>
        <div style="display: flex;justify-content:space-between">
            <div class="titulo">
                <h3>Aperturas/Cierres de caja chica </h3>&nbsp;&nbsp;
                {{-- <div>de Fecha: <input type="text" id="fechax" onchange="cambiafecha(this)" autocomplete="off" style="border:0;background:lemonchiffon;text-align:center" value="{{implode("-",array_reverse(explode("-",$fecha)))}}" readonly></div> --}}
                
            </div>
            {{-- <a href="{{route("ventas.paracerrarcaja")}}" class="btn btn-warning">Ir a cierre de caja</a> --}}
        </div>
        <form action="aperturacajachica2" method="post" id="formuapertura">
            @csrf
            <div class="deposito">
                <span>Depósito:&nbsp;</span>
                <select name="deposito" id="deposito" onchange="document.getElementById('formuapertura').submit()" class="form-control">
                    @foreach ($depositos as $undepot)
                        @if ($undepot->id==$dep)
                            <option value="{{$undepot->id}}" selected="selected">{{$undepot->nombre}}</option>
                        @else
                            <option value="{{$undepot->id}}">{{$undepot->nombre}}</option>
                        @endif
                       
                    @endforeach
                </select>
            </div>
        </form>
       

        {{-- <div class="totalesventadeldia">
            <div id="totaltotal">Total: <span></span></div>
            <div id="contado">Contado: <span></span></div>
            <div id="tarjeta">Tarjeta: <span></span></div>
            <div id="cheque">Cheque: <span></span></div>
            <div id="deposito">Depósito: <span></span></div>
            <div id="transferencia">Transferencia: <span></span></div>
            <div id="credito">Crédito: <span></span></div>
        </div>   --}}

        <table class="table table-light " id="tb_vtasdetallada">
            <thead class="thead-light">
                <tr>
                    {{-- <th></th> --}}
                    <th>N</th>
                    <th>Deposito</th>
                    <th>Fecha</th>
                    <th>Apertura</th>
                    <th>Gastado</th>
                    <th>Saldo</th>
                    {{-- <th>ComisionTotal</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($registros as $key=>$unreg)
                    <tr ondblclick="edita({{json_encode($unreg->idventa)}})">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$unreg->deposito}}</td>
                        <td>{{implode("-",array_reverse(explode("-",$unreg->fecha)))}}</td>
                        <td ondblclick="edita(event,{{$unreg}},this)">{{$unreg->apertura}}</td>
                        <td>{{$unreg->gastado}}</td>
                        <td>{{$unreg->saldo}}</td>
                    </tr>
                @endforeach
                {{-- <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="font-weight:bold;font-size:1.5em">0</td></tr> --}}
            </tbody>
        </table>
        {{-- <form action="{{route("ventas.detallev")}}" method="get" id="formufecha">
            @csrf
                <input type="hidden" name="fecha" id="fecha" class="form-control">
        </form>
        <form action="{{route("ventas.editaventa")}}" method="post" id="formuedit">
            @csrf
                <input type="hidden" name="idventa" id="idventa" class="form-control">
        </form> --}}
        
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>
    // window.onload=function(){
        // totaliza();
    //     tb=document.getElementById("tb_vtasdetallada");
    //     nrofilas=tb.rows.length-1;
    //     total=0;
    //     for(k=1;k<nrofilas;k++){
    //         if(tb.rows[k].cells[9].innerText!=""){
    //             tb.rows[k].className="coloreagris";
    //         }
    //         else{
    //             tb.rows[k].className="coloreayellow";
    //         }
    //     }
    //     $("#fechax").datepicker({
    //                     changeMonth: true,
    //                     changeYear: true,
    //                     dateFormat:"dd-mm-yy",
    //                     closeText: 'Cerrar',
    //                     prevText: '<Ant',
    //                     nextText: 'Sig>',
    //                     currentText: 'Hoy',
    //                     monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    //                     monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    //                     dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    //                     dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    //                     dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    //                     weekHeader: 'Sm',
    //                     firstDay: 1,
    //                     isRTL: false,
    //                     showMonthAfterYear: false,
    //                     yearSuffix: ''
    //     });
    // }

    // function totaliza(){
    //     tb=document.getElementById("tb_vtasdetallada");
    //     nrofilas=tb.rows.length-1;
    //     total=0;
    //     var totaliza=0;              
    //     var tcontado = 0;
    //     var ttarjeta = 0;
    //     var tcheque = 0;
    //     var tdeposito = 0;
    //     var ttransferencia=0;
    //     var tcredito=0;
    //     for(k=1;k<nrofilas;k++){
    //             subtotal= parseFloat(tb.rows[k].cells[13].innerText);
    //             total=total + subtotal;
    //             //////////////////////
                
    //             formapago=tb.rows[k].cells[8].innerText;
    //                 switch (formapago) {
    //                     case "contado":
    //                             tcontado+=parseFloat(subtotal);
    //                     break;
    //                     case "tarjeta":
    //                         ttarjeta+=parseFloat(subtotal);
    //                     break;
    //                     case "cheque":
    //                         tcheque+=parseFloat(subtotal);
    //                     break;
    //                     case "deposito":
    //                         tdeposito+=parseFloat(subtotal);
    //                     break;
    //                     case "transferencia":
    //                         ttransferencia+=parseFloat(subtotal);
    //                     break;
    //                     case "credito":
    //                         tcredito+=parseFloat(subtotal);
    //                     break;
    //                 }
    //                 totaliza += parseFloat(subtotal);
               
    //             console.log("totaliza:",totaliza);
    //             ////////////////////////
    //     }
    //     document.getElementById("total").innerText=total;
    //     document.getElementById("totaltotal").querySelector("span").innerText=totaliza;
    //     document.getElementById("contado").querySelector("span").innerText=tcontado;
    //     document.getElementById("tarjeta").querySelector("span").innerText=ttarjeta;
    //     document.getElementById("cheque").querySelector("span").innerText=tcheque;
    //     document.getElementById("deposito").querySelector("span").innerText=tdeposito;
    //     document.getElementById("transferencia").querySelector("span").innerText=ttransferencia;
    //     document.getElementById("credito").querySelector("span").innerText=ttransferencia;
    // }
    // function cambiafecha(){
    //     document.getElementById("fecha").value=document.getElementById("fechax").value.split("-").reverse().join("-");
    //     document.getElementById("formufecha").submit();
    // }
    dataenvio=[];
    function edita(e,unregistro,celda){

        dataenvio=[];
        // dataenvio.push(unregistro);
        e.stopPropagation();
        console.log(unregistro);
        contenido=celda.parentElement.cells[3].innerText;
        // saldo=celda.parentElement.cells[5].innerText;
        input=document.createElement("input");
        input.value=contenido;
        
        celda.innerText="";
        celda.append(input);
        dataenvio.push(unregistro);
        input.onblur=function(){
            dataenvio[0].apertura=input.value;
            console.log(dataenvio);
            guarda(dataenvio,celda,unregistro.id);
        };
        input.ondblclick=function(e){
            e.stopPropagation();
        }
        input.focus();
    }
    function guarda(dataenvio,celda,unregistro){
        
        // dataenvio=[{proveedor:document.getElementById("proveedor").value,nit:document.getElementById("nit").value,detalle:prods,total:document.getElementById("total").value,idusr:"100",formapago:document.getElementById("formapago").value,comentario:document.getElementById("comentario").value,idneg:document.getElementById("deposito").value,credito:credito}];
            console.log(" a guardar: ",dataenvio);
            fetch('guardaapertura', {
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
                // alert(" REGISTRADA");
                celda.innerText=dataenvio[0].apertura;
                fila=celda.parentElement;
                fila.cells[5].innerText=dataenvio[0].apertura - dataenvio[0].gastado;
                
            });
    }
</script>
@endsection