@extends(session("usr")->rol=="Vendedores"?"layouts.plantillasaldos":'') 
@section('contenido')
    {{-- <div style="display: flex;justify-content:space-between"> --}}
        <div class="titulo">
            <h3>Ventas Sin Vendedor Asignado</h3>&nbsp;&nbsp;
            {{-- <div>de Fecha: <input type="text" id="fechax" onchange="cambiafecha(this)" autocomplete="off" style="border:0;background:lemonchiffon;text-align:center" value="{{implode("-",array_reverse(explode("-",$fecha)))}}" readonly></div> --}}
            
        </div>
    {{-- </div> --}}

    <table class="table table-light " id="tb_sinvendedor">
        <thead class="thead-light">
            <tr>
                {{-- <th></th> --}}
                <th>N</th>
                <th>IdVenta</th>
                <th>Depósito</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Telefono</th>
                <th>Descripcion</th>
                <th>PrecioVenta</th>
                <th>PrecioFinal</th>
                <th>Cantidad</th>
                <th>Comisión</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lista as $key=>$unprod)
                <tr >
                    <td>{{$loop->iteration}}</td>
                    <td>{{$unprod->idventa}}</td>
                    <td>{{$unprod->deposito}}</td>
                    <td>{{implode("-",array_reverse(explode("-",explode(" ",$unprod->fecha)[0])))." ".explode(" ",$unprod->fecha)[1]}}</td>
                    <td>{{$unprod->cliente}}</td>
                    <td>{{$unprod->telefono}}</td>
                    <td>{{$unprod->descripcion}}</td>
                    <td>{{$unprod->precioventa}}</td>
                    <td>{{$unprod->preciofinal}}</td>
                    <td>{{$unprod->cuantos}}</td>
                    <td>{{$unprod->comision * $unprod->cuantos}}</td>
                </tr>
            @endforeach
            {{-- <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="font-weight:bold;font-size:1.5em">0</td></tr> --}}
        </tbody>
    </table>
        
@endsection
@section('js')


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<script>
     $(document).ready(function() {
                    mitabla= $('#inventario').DataTable({
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
                    })
                    
    } );
</script>
@endsection