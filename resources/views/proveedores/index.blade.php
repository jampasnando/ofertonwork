@extends('layouts.plantillabase')
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <div class="titulo"><h3>Proveedores</h3></div>
        <div class="botonesheader"><div><a href="{{route("nuevoprov")}}" class="btn btn-success">Nuevo Proveedor</a> <a href="{{route("exportarproveedores")}}" class="btn btn-secondary">Exportar a Excel</a></div><div>{{$lista->links()}}</div></div>
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>N</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $unprov)
                    <tr>
                        <td>{{$unprov->id}}</td>
                        <td>{{$unprov->nombre}}</td>
                        <td>{{$unprov->direccion}}</td>
                        <td>{{$unprov->ciudad}}</td>
                        <td>{{$unprov->contacto}}</td>
                        <td>{{$unprov->telefono}}</td>
                        <td><a href="{{route('editaprov',$unprov->id)}}" class="btn btn-secondary">Editar</a></td>
                        <td>
                            <form action="{{route('eliminaprov',$unprov->id)}}" method="post">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Está seguro de eliminar este proveedor?')" >Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{$lista->links()}}</div>
@endsection