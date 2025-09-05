@extends(session("usr")->rol=="Enc. Tienda y caja"?"layouts.plantillavendedor":'layouts.plantillabase') 
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <br>
        {{-- <div class="titulo"><h3>Histórico de Cierres <span style="color:darkorange"></span></h3>&nbsp;&nbsp;
            <a href="{{route("ventas.paracerrarcaja")}}" class="btn btn-warning">Ir a cierre de caja</a>
        </div> --}}
        @php
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        @endphp
        <div class="titulo">
            <h3>Tienda - preventas <span style="color:darkorange"> del mes </span></h3>
            <div> <input onchange="cambiafecha(this)" type="text" id="fechax"  autocomplete="off" style="border:0;background:lemonchiffon;text-align:center" value="{{$mesanox}}" readonly></div>
            {{-- <span>{{$mesanox ?? ''}}</span> --}}
        </div>

        <table class="table table-light " id="tb_cierres">
            <thead class="thead-light">
                <tr>
                    {{-- <th></th> --}}
                    <th>N</th>
                    <th>Fecha</th>
                    <th>Id</th>
                    <th>Contenido</th>
                    <th>Cliente</th>
                    <th>Celular</th>
                    <th>Vendedor</th>
                    <th>MetodoPago</th>
                    <th>Dep</th>
                    <th>Origen</th>
                    {{-- <th>Total</th> --}}
                    <th>Acción</th>
                    {{-- <th>ComisionTotal</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $key=>$unacompra)
                    <tr >
                        <td>
                            {{$loop->iteration}} <input type="hidden" name="id_{{$loop->iteration}}" id="id_{{$loop->iteration}}" value="{{$unacompra->id}}">
                            <input type="hidden" class="estado" value="{{$unacompra->estado}}">
                        </td>
                        <td>{{implode("-",array_reverse(explode("-",explode(" ",$unacompra->fecha_creacion)[0])))." ".explode(" ",$unacompra->fecha_creacion)[1]}}</td>
                        <td>{{$unacompra->id}}</td>
                        <td style="font-size: 0.6em;">{{$unacompra->json}}</td>
                        <td>{{$unacompra->cliente}}</td>
                        <td>
                            <a href="https://api.whatsapp.com/send?phone=591{{$unacompra->celular}}" class="btn btn-outline-success" target="_blank">
                                <img src="{{url('/imagenes/logowhats.png')}}" alt="" style="height: 1.2em;">&nbsp;&nbsp;{{$unacompra->celular}}
                              </a>
                            
                        </td>
                        <td>
                            <a href="https://api.whatsapp.com/send?phone=591{{json_decode($unacompra->json)[0]->unvendedor->telefono}}" class="btn btn-outline-success" target="_blank">
                                <img src="{{url('/imagenes/logowhats.png')}}" alt="" style="height: 1.2em;">&nbsp;&nbsp;{{json_decode($unacompra->json)[0]->unvendedor->telefono}}
                              </a>
                            
                        </td>
                        <td>{{$unacompra->metodopago}}</td>
                        <td>{{$unacompra->deposito}}</td>
                        <td>{{$unacompra->origen}}</td>
                        {{-- <td>{{$unacompra->total}}</td> --}}
                        <td><a href="{{route("detalleventatienda",["id"=>$unacompra->id])}}" class="btn btn-warning" target="_blank">Ver Detalle</a></td>
                    </tr>
                @endforeach
                {{-- <tr><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="font-weight:bold;font-size:1.5em">0</td></tr> --}}
            </tbody>
        </table>
        <form action="listapreventasmes" method="post" id="cierremes">
            @csrf
            <input type="hidden" name="mesano" id="mesano">
        </form>
        {{-- <form action="{{route("guardapagocomision")}}" method="post" id="formupago">
            @csrf
            <div class="col-12">
                <label for="obs">Apuntes, observaciones, nro de recibo, etc:</label>
                <input type="text" name="obs" id="obs" class="form-control">
            </div>
            <input type="hidden" name="ids" id="ids">
        </form> --}}
        
@endsection
@section('css')
 <style>
    .ui-datepicker-calendar {
        display: none;
    }
    button.ui-datepicker-current { display: none; }
 </style>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
{{-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script> --}}
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>
    window.onload=function(){
        tb=document.getElementById("tb_cierres");
        pintavendidos();
        $("#fechax").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'MM yy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            closeText : "Aceptar",
            onClose: function(dateText, inst) { 
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                console.log("cambiafecha a: ",document.getElementById("fechax").value);
                document.getElementById("mesano").value=document.getElementById("fechax").value;
                document.getElementById("cierremes").submit();
            }
            // dateFormat:"dd-mm-yy",
            // closeText: 'Cerrar',
            // prevText: '<Ant',
            // nextText: 'Sig>',
            // currentText: 'Hoy',
            // monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            // monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            // dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            // dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            // dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            // weekHeader: 'Sm',
            // firstDay: 1,
            // isRTL: false,
            // showMonthAfterYear: false,
            // yearSuffix: ''
        });

    }
    function cambia(chk){
        console.log(chk.checked);
        color="";
        if(chk.checked){
            color="lightyellow";
        }
        else{
            color="snow";
        }
        chk.parentElement.style.background="red";
        celdas=chk.parentElement.parentElement.querySelectorAll("td");
        for(i=0;i<celdas.length;i++){
            celdas[i].style.background=color;
        }
        // totaliza();
    }
    function totaliza(){
        tb=document.getElementById("tb_cierres");
        nrofilas=tb.rows.length-1;
        total=0;
        for(k=1;k<nrofilas;k++){
            // if(document.getElementById("ch_"+k).checked){
                total=total + parseFloat(tb.rows[k].cells[4].innerText);
            // }
        }
        document.getElementById("total").innerText=total;
    }
    function pintavendidos(){
        tb=document.getElementById("tb_cierres");
        nrofilas=tb.rows.length;
        for(k=1;k<nrofilas;k++){
            console.log(tb.rows[k].cells[0].querySelector(".estado"));
            if( tb.rows[k].cells[0].querySelector(".estado").value!="pendiente"){
                console.log("hallado",k);
                for(j=0;j<=10;j++){
                    tb.rows[k].cells[j].style.background="#90ee904a";
                }
            }
           
        }
    }
    // function cambiafecha(){
    //     document.getElementById("fecha").value=document.getElementById("fechax").value.split("-").reverse().join("-");
    //     document.getElementById("formufecha").submit();
    // }

</script>
@endsection