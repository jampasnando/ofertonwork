@extends('layouts.plantillabase')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
@endsection
@section('contenido')
@if (session("prodeliminado"))
<div class="alert alert-success">{{session("prodeliminado")}}</div>
@endif
<div class="titulo">
    <h3>Ventas </h3>&nbsp;&nbsp;<div>de Fecha: <input type="text" id="fecha" onchange="cambiafecha(this)"
            autocomplete="off" style="border:0;background:lemonchiffon;text-align:center" value="{{date('d-m-Y')}}"
            readonly></div>
</div>
<div class="botonesheader">
    <div>
        <a href="{{route("nuevaventa")}}" class="btn btn-success">Nueva Venta</a>
        <a href="{{route("lec.export")}}" class="btn btn-warning">Exportar a Excel</a>


    </div>

</div>
<div class="totalesventadeldia">
    <div id="totaltotal">Total: <span></span></div>
    {{-- <div id="pagado">Pagado: <span></span></div> --}}
    <div id="credito" style="color:red;">Credito: <span></span></div>
    <div id="contado">Efectivo: <span></span></div>
    <div id="tarjeta">Tarjeta: <span></span></div>
    <div id="cheque">Cheque: <span></span></div>
    <div id="deposito">Depósito: <span></span></div>
    <div id="transferencia">Transferencia: <span></span></div>
    <div id="qr">QR: <span></span></div>
    
</div>
<table class="table table-light table-hover" id="ventas">
    <thead class="thead-light">
        <tr>
            {{-- <th>N</th> --}}
            {{-- <th>Idventa</th> --}}
            <th>Deposito</th> 
            <th>Total</th>
            <th>Pagado</th>
            <th>Saldo</th>
            <th>Cliente</th>
            <th>NIT</th>
            <th>FormaPago</th>
            <th>Fecha</th>
            <th>Comentario</th>
            <th>Vendedor</th>
            <th>Usuario</th>
            <th></th>
        </tr>
    </thead>
</table>
<form method="post" id="formeditar" action="{{route('ventas.editaventa')}}" target="_blank">
    @csrf
    <input type="hidden" name="idventa" id="idventa" class="form-control">
</form>
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
{{--
<link rel="stylesheet" href="/resources/demos/style.css"> --}}
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<script>
    var datatabla;
    var totaliza=0;              
    var tcontado = 0;
    var ttarjeta = 0;
    var tcheque = 0;
    var tdeposito = 0;
    var ttransferencia = 0;
    var tqr = 0;
    var tcredito = 0;
    var tpago = 0;
                $(document).ready(function() {
                            jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
                                return this.flatten().reduce( function ( a, b ) {
                                    if ( typeof a === 'string' ) {
                                        a = a.replace(/[^\d.-]/g, '') * 1;
                                    }
                                    if ( typeof b === 'string' ) {
                                        b = b.replace(/[^\d.-]/g, '') * 1;
                                    }
                            
                                    return a + b;
                                }, 0 );
                            } );
                    datatabla=$('#ventas').DataTable({
                        "ajax":{
                            url:"{{route('datatablecontrventas')}}",
                            data:{
                                fecha:function(){return document.getElementById("fecha").value.split("-").reverse().join("-");}
                            },
                        },
                        "columns":[
                            // {data:'id'},
                            // {data:'idventa'},
                            {data:'idneg'},
                            {data:'total'},
                            {data:'pago'},
                            {data:'saldo'},
                            {data:'cliente'},
                            {data:'nit'},
                            {data:'formapago'},
                            {data:'fecha'},
                            {data:'comentario'},
                            {data:'vendedor'},
                            {data:'idusr'},
                            {data:'actions',orderable:false}
                        ],
                        "order":[[7,"desc"]],
                        "language":{
                            "emptyTable":     "No hay datos en la Tabla",
                            "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                            "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                            "infoFiltered":   "(Filtrado de _MAX_ total registros)",
                            "infoPostFix":    "",
                            "thousands":      ",",
                            "lengthMenu":     "Mostrar _MENU_ registros",
                            "loadingRecords": "Loading...",
                            "processing":     "Procesando...",
                            "search":         "Buscar:",
                            "zeroRecords":    "No matching records found",
                            "paginate": {
                                "first":      "Primero",
                                "last":       "Ultimo",
                                "next":       "Siguiente",
                                "previous":   "Previo"
                            }
                        },
                        "footerCallback": function (row, data, start, end, display) {  
                                    
                                    for (var i = 0; i < data.length; i++) {
                                        switch (data[i]["formapago"]) {
                                            case "efectivo":
                                                 tcontado+=parseFloat(data[i]["total"]);
                                            break;
                                            case "tarjeta":
                                                ttarjeta+=parseFloat(data[i]["total"]);
                                            break;
                                            case "cheque":
                                                tcheque+=parseFloat(data[i]["total"]);
                                            break;
                                            case "deposito":
                                                tdeposito+=parseFloat(data[i]["total"]);
                                            break;
                                            case "transferencia":
                                                ttransferencia+=parseFloat(data[i]["total"]);
                                            break;
                                            case "qr":
                                                tqr+=parseFloat(data[i]["total"]);
                                            break;
                                            case "credito":
                                                tcredito+=parseFloat(data[i]["total"]);
                                            break;
                                        }
                                        totaliza += parseFloat(data[i]["total"]);
                                        // tpago += parseFloat(data[i]["pago"]);
                                    }
                                    document.getElementById("totaltotal").querySelector("span").innerText=totaliza;
                                    // document.getElementById("pagado").querySelector("span").innerText=tpago;
                                    document.getElementById("credito").querySelector("span").innerText=tcredito;
                                    document.getElementById("contado").querySelector("span").innerText=tcontado;
                                    document.getElementById("tarjeta").querySelector("span").innerText=ttarjeta;
                                    document.getElementById("cheque").querySelector("span").innerText=tcheque;
                                    document.getElementById("deposito").querySelector("span").innerText=tdeposito;
                                    document.getElementById("transferencia").querySelector("span").innerText=ttransferencia;
                                    document.getElementById("qr").querySelector("span").innerText=tqr;
                                    
                                    console.log("totaliza:",totaliza);
                        },
                        "createdRow": function( row, data, dataIndex){
                            console.log("enCreatedRow",row,data,dataIndex);
                            console.log("pagomixto: ",data["pagomixto"]);
                            if(data["pagomixto"]!=null){
                                mixtojson=JSON.parse(decodeHtml(data["pagomixto"]));
                                console.log(mixtojson);
                                title="";
                                Object.entries(mixtojson).forEach(unmixto => {
                                    [key,valor]=unmixto;
                                    title+=key + ":" + valor + " | ";
                                    row.cells[6].title=title;
                                    switch (key) {
                                            case "efectivo":
                                                 tcontado+=parseFloat(valor);
                                            break;
                                            case "tarjeta":
                                                ttarjeta+=parseFloat(valor);
                                            break;
                                            case "cheque":
                                                tcheque+=parseFloat(valor);
                                            break;
                                            case "deposito":
                                                tdeposito+=parseFloat(valor);
                                            break;
                                            case "transferencia":
                                                ttransferencia+=parseFloat(valor);
                                            break;
                                            case "qr":
                                                tqr+=parseFloat(valor);
                                            break;
                                            case "credito":
                                                tcredito+=parseFloat(valor);
                                            break;
                                    }
                                });
                                
                            }
                            
                            // if(parseFloat(data["total"])>160){
                            //     console.log(data["total"]);
                            //     $(row).find("td").css("background","pink");
                            // }
                        }
                    });
                    $("#fecha").datepicker({
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
                } );
                function decodeHtml(html) {
                    var txt = document.createElement("textarea");
                    txt.innerHTML = html;
                    return txt.value;
                }
                function  cambiafecha(calendario){
                    // nuevafecha=calendario.value;
                    // console.log("nuevafecha",nuevafecha);
                     totaliza=0;              
                     tcontado = 0;
                     ttarjeta = 0;
                     tcheque = 0;
                     tdeposito = 0;
                     ttransferencia = 0;
                     tqr = 0;
                     tcredito = 0;
                    //  tpago = 0;
                    datatabla.ajax.reload();
                }
                function editar(idventa){
                    console.log("editara: ",idventa);
                    document.getElementById("idventa").value=idventa;
                    document.getElementById("formeditar").submit();
                }
</script>
@endsection
@endsection