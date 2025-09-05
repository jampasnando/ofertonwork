
@extends('layouts.plantillavendedor')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <style>
        #inventario_processing{
            background: black;
            color: white;
            width: 20em;
        }
    </style>
@endsection
@section('contenido')
        @if (session("prodeliminado"))
            <div class="alert alert-success">{{session("prodeliminado")}}</div>
        @endif
        <div class="titulo">
            <h3>Inventario&nbsp;</h3>
            <div class="deposito">
                    <span>Depósito:&nbsp;</span>
                    <select name="deposito" id="deposito" onchange="filtrar()" class="form-control">
                        <option value="">Todo</option>
                        @foreach ($depositos as $undepot)
                            @php
                                if($undepot->id==session("usr")->ciudad){
                                    $seleccionado="selected='selected'";
                                }
                                else{
                                    $seleccionado="";
                                }
                            @endphp
                            <option value="{{$undepot->nombre}}" {{$seleccionado}}>{{$undepot->nombre}}</option>
                        @endforeach
                    </select>
            </div>
           
        </div>
        {{-- <div class="botonesheader">
            <div>
                <a href="{{route("nuevoprod")}}" class="btn btn-success">Nuevo Producto</a> 
                <a href="{{route("inventario.importar")}}" class="btn btn-warning">Importar desde Excel</a>
                <a href="{{route("inventario.exportar")}}" class="btn btn-info">Exportar a Excel</a>
            </div>
        </div> --}}
            
        <table class="table table-light table-hover" id="inventario">
            <thead class="thead-light">
                <tr>
                    <th>N</th>
                    <th>Id</th>
                    <th>Descripcion</th>
                    <th>Marca</th>
                    <th>Cantidad</th>
                    <th>Categoria</th>
                    <th>Unidad</th>
                    {{-- <th>PrecioLocal</th> --}}
                    <th>PrecioVenta</th>
                    {{-- <th>Comision</th> --}}
                    <th>Depósito</th>
                    <th>Proveedor</th>
                    {{-- <th>Acciones</th> --}}
                </tr>
            </thead>
        </table>
        <form action="" method="post" style="display:none" id="formuelim">
            @csrf 
            @method("DELETE")
           
        </form>
        @section('js')
            <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
            <script>
                eldeposito=document.getElementById("deposito").value;
                $(document).ready(function() {
                    mitabla= $('#inventario').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax":{
                            url:"{{route('datatablecontr')}}",
                            data:function ( d ) {
                                return $.extend( {}, d, {
                                    "deposito":eldeposito
                                } );
                            },
                        },
                        "type":"post",
                        
                        "bDestroy": true,
                        "columns":[
                            {data:'id'},
                            {data:'idprod'},
                            {data:'descripcion'},
                            {data:'marca'},
                            {data:'cantidad'},
                            {data:'categoria'},
                            {data:'unidad'},
                            // {data:'preciolocal'},
                            {data:'precioventa'},
                            // {data:'comision'},
                            {data:'nombre'},
                            {data:'proveedor'},
                            // {data:'actions',orderable:false}
                        ],
                        "language":{
                            "emptyTable":     "No hay datos en la Tabla",
                            "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                            "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                            "infoFiltered":   "(Filtrado de _MAX_ total registros)",
                            "infoPostFix":    "",
                            "thousands":      ",",
                            "lengthMenu":     "Mostrar _MENU_ registros",
                            "loadingRecords": "Cargando datos...",
                            "processing":     "Procesando...",
                            "search":         "",
                            "zeroRecords":    "No se hallaron coincidencias",
                            "paginate": {
                                "first":      "Primero",
                                "last":       "Ultimo",
                                "next":       "Siguiente",
                                "previous":   "Previo"
                            },
                        
                        }
                        
                    });
                    var input = $('.dataTables_filter input').unbind();
                                $searchButton = $('<button>')
                                        .text('Buscar')
                                        .addClass("btn btn-light")
                                        .click(function() {
                                            mitabla.search($('.dataTables_filter input').val()).draw();
                                            dep=document.getElementById("deposito").value;
                                            console.log("deposito: ",dep);
                                            
                                        });
                                $clearButton = $('<button>')
                                        .text('X')
                                        .addClass("btn btn-secondary")
                                        .click(function() {
                                            input.val('');
                                            $searchButton.click(); 
                                        });
                                $('.dataTables_filter input').keypress(function (event) {
                                    if (event.which == 13) {
                                        $searchButton.click();
                                    }
                                });
                            $('.dataTables_filter').append($searchButton, $clearButton);
                    
                } );
                            
                
                function filtrar(){
                    console.log("entra a filtrar");
                    eldeposito=document.getElementById("deposito").value;
                    mitabla.draw();
                }
            </script>
        @endsection
@endsection
<script>
    function cambiadepot(){
        document.getElementById("formu").submit();  
    }
    function (idprod){
        if(confirm("Está seguro de eliminar este producto?")){
            document.getElementById("formuelim").action="eliminaprod/"+idprod;
            document.getElementById("formuelim").submit();
        }
    }
</script>