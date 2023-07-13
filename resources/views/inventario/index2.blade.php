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
    <h3>Inventario&nbsp;</h3>
    <div class="deposito">
        <form action="inventario2" method="post" id='formudep'>
            @csrf
            <span>Depósito:&nbsp;</span>
            <select name="deposito" id="deposito" onchange="eligedep()" class="form-control">
                <option value="">Todo</option>
                @foreach ($depositos as $undepot)
                    <option value="{{$undepot->nombre}}">{{$undepot->nombre}}</option>
                @endforeach
            </select>
        </form>
    </div>

    </div>
    <div class="botonesheader">
    <div>
        <a href="{{route("nuevoprod")}}" class="btn btn-success">Nuevo Producto</a> 
        <a href="{{route("inventario.importar")}}" class="btn btn-warning">Importar desde Excel</a>
        <a href="{{route("inventario.exportar")}}" class="btn btn-info">Exportar a Excel</a>
    </div>
    </div>

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
            <th>PrecioLocal</th>
            <th>PrecioVenta</th>
            <th>Comision</th>
            <th>Depósito</th>
            <th>Proveedor</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lista as  $unreg)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$unreg->idprod}}</td>
                <td>{{$unreg->descripcion}}</td>
                <td>{{$unreg->deposito}}</td>
                <td>{{$unreg->cant}}</td>
            </tr>
        @endforeach
    </tbody>
    </table>
    <form action="" method="post" style="display:none" id="formuelim">
    @csrf 
    @method("DELETE")

    </form>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            mitabla= $('#tb_ventasxprod').DataTable({
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
                        "search":         "Buscar:",
                        "zeroRecords":    "No matching records found",
                        "paginate": {
                            "first":      "Primero",
                            "last":       "Ultimo",
                            "next":       "Siguiente",
                            "previous":   "Previo"
                        },
                        
                }
            });
        });
        function eligedep(){
            document.getElementById("formudep").submit();
        }
    </script>
@endsection