@extends('layouts.plantillabase')
@section('contenido')
        @if (session("vendedoreliminado"))
        <div class="alert alert-success">{{session("vendedoreliminado")}}</div>
        @endif
        <div class="titulo"><h3>Usuarios</h3></div>
        <div class="botonesheader">
            <div>
                <a href="{{route("nuevovendedor")}}" class="btn btn-success">Nuevo Usuario</a>
                <a href="{{route("exportarusuarios")}}" class="btn btn-secondary">Exportar a Excel</a>
            </div>
               <div>{{$lista->links()}}</div>
        </div>
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>N</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Ciudad</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $unvendedor)
                    <tr>
                        <td>{{$unvendedor->id}}</td>
                        <td>{{$unvendedor->nombre}}</td>
                        <td>{{$unvendedor->direccion}}</td>
                        <td>{{$unvendedor->telefono}}</td>
                        <td>{{$unvendedor->email}}</td>
                        <td>{{$unvendedor->password}}</td>
                        <td>{{$unvendedor->ciudad}}</td>
                        <td>{{$unvendedor->rol}}</td>
                        <td>{{$unvendedor->estado}}</td>
                        <td><a href="{{route('editavendedor',$unvendedor->id)}}" class="btn btn-secondary">Editar</a></td>
                        <td>
                            <form action="{{route('eliminavendedor',$unvendedor->id)}}" method="post">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Está seguro de eliminar este vendedor?')" >Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{$lista->links()}}</div>
@endsection