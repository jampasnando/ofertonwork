@extends('layouts.plantillabase')
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <div class="titulo"><h3>Ventas por producto</h3></div>
        <a href="{{route("exportarventas")}}" class="btn btn-warning">Exportar Detalle a Excel</a>
        <table class="table table-light" id="tb_ventasxprod">
            <thead class="thead-light">
                <tr>
                    <th>N</th>
                    <th>Idprod</th>
                    <th>Descripción</th>
                    <th>Depósito</th>
                    <th>Vendidos</th>
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
    </script>
@endsection