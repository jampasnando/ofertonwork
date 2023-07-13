
@extends('layouts.plantillabase')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
@endsection
@section('contenido')
        @if (session("prodeliminado"))
            <div class="alert alert-success">{{session("prodeliminado")}}</div>
        @endif
        <div class="titulo"><h3>Compras </h3>&nbsp;&nbsp;
            {{-- <div>de Fecha: <input type="text" id="fecha" onchange="cambiafecha(this)" autocomplete="off" style="border:0;background:aliceblue;text-align:center" value="{{date('d-m-Y')}}" readonly> --}}
            {{-- </div> --}}
        </div>
        <div class="botonesheader">
            <div>
                <a href="{{route("nuevacompra")}}" class="btn btn-success">Nueva Compra</a> 
                {{-- <a href="{{route("lec.export")}}" class="btn btn-warning">Exportar a Excel</a> --}}
                
               
            </div>
            
        </div>
        {{-- <div class="totalesventadeldia">
            <div id="totaltotal">Total: <span></span></div>
            <div id="contado">Contado: <span></span></div>
            <div id="tarjeta">Tarjeta: <span></span></div>
            <div id="cheque">Cheque: <span></span></div>
            <div id="deposito">Depósito: <span></span></div>
            <div id="transferencia">Transferencia: <span></span></div>
        </div>   --}}
        <table class="table table-light table-hover" id="compras">
            <thead class="thead-light">
                <tr>
                    <th>N</th>
                    <th>IdCompra</th>
                    <th>Fecha</th>
                    <th>Deposito</th>
                    <th>Proveedor</th>
                    <th>Factura</th>
                    <th>FormaPago</th>
                    <th>Total</th>
                    <th>Pagado</th>
                    <th>Deuda</th>
                    <th>Comentario</th>
                    {{-- <th>Comprador</th>
                    <th>Usuario</th> --}}
                    <th></th>
                </tr>
            </thead>
        </table>
        @section('js')
            <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
            {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
            <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
            <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

            <script>
                 var datatabla;
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
                    datatabla=$('#compras').DataTable({
                        processing:true,
                        serverSide:true,
                        "ajax":{
                            url:"{{route('datatablecontrcompras')}}",
                            data:{
                                // fecha:function(){return document.getElementById("fecha").value.split("-").reverse().join("-");}
                                fecha:""
                            },
                        },
                        "columns":[
                            {data:'id'},
                            {data:'idcompra'},
                            {data:'fecha'},
                            {data:'idneg'},
                            {data:'proveedor'},
                            {data:'factura'},
                            {data:'formapago'},
                            {data:'total'},
                            {data:"pagado"},
                            {data:"deuda"},
                            {data:'comentario'},
                            // {data:'comprador'},
                            // {data:'idusr'},
                            {data:'actions',orderable:false}
                        ],
                        "order":[[2,"desc"]],
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
                        // "footerCallback": function (row, data, start, end, display) {  
                        //             var totaliza=0;              
                        //             var tcontado = 0;
                        //             var ttarjeta = 0;
                        //             var tcheque = 0;
                        //             var tdeposito = 0;
                        //             var ttransferencia = 0;
                        //             for (var i = 0; i < data.length; i++) {
                        //                 switch (data[i]["formapago"]) {
                        //                     case "contado":
                        //                          tcontado+=parseFloat(data[i]["total"]);
                        //                     break;
                        //                     case "tarjeta":
                        //                         ttarjeta+=parseFloat(data[i]["total"]);
                        //                     break;
                        //                     case "cheque":
                        //                         tcheque+=parseFloat(data[i]["total"]);
                        //                     break;
                        //                     case "deposito":
                        //                         tdeposito+=parseFloat(data[i]["total"]);
                        //                     break;
                        //                     case "transferencia":
                        //                         ttransferencia+=parseFloat(data[i]["total"]);
                        //                     break;
                        //                 }
                        //                 totaliza += parseFloat(data[i]["total"]);
                        //                 // console.log("undato: ",data[i]["total"]);
                        //             }
                        //             document.getElementById("totaltotal").querySelector("span").innerText=totaliza;
                        //             document.getElementById("contado").querySelector("span").innerText=tcontado;
                        //             document.getElementById("tarjeta").querySelector("span").innerText=ttarjeta;
                        //             document.getElementById("cheque").querySelector("span").innerText=tcheque;
                        //             document.getElementById("deposito").querySelector("span").innerText=tdeposito;
                        //             console.log("totaliza:",totaliza);
                        // }
                        // "createdRow": function( row, data, dataIndex){
                        //     console.log("enCreatedRow",row);
                        //     if(parseFloat(data["total"])>160){
                        //         console.log(data["total"]);
                        //         $(row).find("td").css("background","pink");
                        //     }
                        // }
                        "createdRow":function(row, data, dataIndex){
                            console.log(data.formapago);
                                if(data.formapago=="credito"){
                                   console.log(row);
                                    $(row).find("td").css("background","aliceblue");
                                    $(row).find("td:nth-child(10)").css("color","red");
                                    // $(row).find("td").css("background","lightyellow");
                                }   
                            
                        }
                    }
                        
                    );
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
                   

                });
                function  cambiafecha(calendario){
                    // nuevafecha=calendario.value;
                    // console.log("nuevafecha",nuevafecha);
                    datatabla.ajax.reload();
                }
                function eliminacompra(idcompra){
                    console.log(idcompra);
                }
            </script>
        @endsection
@endsection