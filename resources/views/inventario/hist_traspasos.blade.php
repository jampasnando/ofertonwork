@extends('layouts.plantillabase')
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <br>
        <div class="titulo"><h3>Traspasos de inventario<span style="color:darkorange"></span></h3></div>
        <table class="table table-light table-stripped table-hover" id="tb_historialtrasp">
            <thead class="thead-light">
                <tr>
                    <th>N</th>
                    <th>IdProd</th>
                    <th>Descripcion</th>
                    <th>Marca</th>
                    <th>Cantidad</th>
                    <th>PrecioLocal</th>
                    <th>PrecioVenta</th>
                    <th>Comision</th>
                    <th>Deposito</th>
                    <th>DepDestino</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Comentario</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $key=>$unprod)
                    <tr>
                        {{-- <td></td> --}}
                        <td>{{$loop->iteration}} <input type="hidden" name="id_{{$loop->iteration}}" id="id_{{$loop->iteration}}" value="{{$unprod->id}}"></td>
                        <td>{{$unprod->idprod}}</td>
                        <td>{{$unprod->descripcion}}</td>
                        <td>{{$unprod->marca}}</td>
                        <td>{{$unprod->cantidad}}</td>
                        <td>{{$unprod->preciolocal}}</td>
                        <td>{{$unprod->precioventa}}</td>
                        <td>{{$unprod->comision}}</td>
                        <td>{{$unprod->deposito}}</td>
                        <td>{{$unprod->depdestino}}</td>
                        <td>{{$unprod->traspasado}}</td>
                        <td>{{implode("-",array_reverse(explode("-",explode(" ",$unprod->fecha)[0])))." ".explode(" ",$unprod->fecha)[1]}}</td>
                        <td>{{$unprod->usuario}}</td>
                        <td>{{$unprod->observaciones}}</td>
                        {{-- <td><a href="{{route('pagacomision',$unprod->id)}}" class="btn btn-warning">Pagar</a></td> --}}
                    </tr>
                @endforeach
                {{-- <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="font-weight:bold;font-size:1.5em">0</td></tr> --}}
            </tbody>
        </table>
        {{-- <div>{{$lista->links()}}</div> --}}
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<script>
     $(document).ready(function() {
                    mitabla= $('#tb_historialtrasp').DataTable({
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
                        
                        },
                        "pageLength": 50
                    })
                    
    } );
</script>

