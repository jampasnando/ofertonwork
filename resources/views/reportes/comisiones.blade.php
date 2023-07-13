@extends('layouts.plantillabase')
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <div class="titulo"><h3>Comisiones Pendientes de Pago</h3></div>
        {{-- <div class="botonesheader"><div><a href="{{route("nuevoprov")}}" class="btn btn-success">Nuevo Proveedor</a> <a href="{{route("lec.export")}}" class="btn btn-warning">Exportar a Excel</a></div><div>{{$lista->links()}}</div></div> --}}
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>N</th>
                    <th>Vendedor</th>
                    <th>Pendiente(Bs)</th>
                    <th>NroProductos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as  $unacom)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$unacom->nombre}}</td>
                        <td>{{$unacom->pendientes}}</td>
                        <td>{{$unacom->nroprods}}</td>
                        <td><a href="{{route('pagacomision',["idv"=>$unacom->id,"nombre"=>$unacom->nombre])}}" class="btn btn-warning">Pagar</a></td>
                        {{-- <td>
                            <form action="{{route('eliminaprov',$unprov->id)}}" method="post">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Está seguro de eliminar este proveedor?')" >Borrar</button>
                            </form>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <div>{{$lista->links()}}</div> --}}
@endsection