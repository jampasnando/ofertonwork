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
            <h3>Historial de cambios <span style="color:darkorange"> del mes </span></h3>
            <div> <input onchange="cambiafecha(this)" type="text" id="fechax"  autocomplete="off" style="border:0;background:lemonchiffon;text-align:center" value="{{$mesanox}}" readonly></div>
            {{-- <span>{{$mesanox ?? ''}}</span> --}}
        </div>

        <table class="table table-light " id="tb_cierres">
            <thead class="thead-light">
                <tr>
                    {{-- <th></th> --}}
                    <th>N</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Motivo</th>
                    <th>Cambio</th>
                    <th>observacion</th>
                    {{-- <th>ComisionTotal</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $key=>$uncierre)
                    <tr >
                        <td>{{$loop->iteration}} <input type="hidden" name="id_{{$loop->iteration}}" id="id_{{$loop->iteration}}" value="{{$uncierre->id}}"></td>
                        <td>{{implode("-",array_reverse(explode("-",explode(" ",$uncierre->fecha)[0])))." ".explode(" ",$uncierre->fecha)[1]}}</td>
                        <td>{{json_decode($uncierre->usuario)->email}}</td>
                        <td>{{$uncierre->motivo}}</td>
                        <td>{{$uncierre->query}}</td>
                        <td>{{$uncierre->obs}}</td>
                    </tr>
                @endforeach
                {{-- <tr><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="font-weight:bold;font-size:1.5em">0</td></tr> --}}
            </tbody>
        </table>
        <form action="historialqueries" method="post" id="cierremes">
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
        // totaliza();
        tb=document.getElementById("tb_cierres");
        // nrofilas=tb.rows.length-1;
        // total=0;
        // for(k=1;k<nrofilas;k++){
        //     if(tb.rows[k].cells[4].innerText!=""){
        //         tb.rows[k].className="coloreagris";
        //     }
        //     else{
        //         tb.rows[k].className="coloreayellow";
        //     }
        // }
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
        totaliza();
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
    // function cambiafecha(){
    //     document.getElementById("fecha").value=document.getElementById("fechax").value.split("-").reverse().join("-");
    //     document.getElementById("formufecha").submit();
    // }

</script>
@endsection