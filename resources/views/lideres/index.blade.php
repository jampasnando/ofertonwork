@extends('layouts.plantillabase')
@section('contenido')
    <h3>Usuarios</h3>
    <a href="{{route("usr.export")}}" class="btn btn-warning">Exportar a Excel</a>
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Regional</th>
                <th>CI</th>
                <th>Celular</th>
                <th>Estado</th>
                <th>Rol</th>
                <th>Servidor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usr)
            <tr>
                <td>{{$usr->id}}</td>
                <td>{{$usr->nombre}}</td>
                <td>{{$usr->regional}}</td>
                <td>{{$usr->ci}}</td>
                <td>{{$usr->celular}}</td>
                <td>{{$usr->estado}}</td>
                <td>{{$usr->rol}}</td>
                <td>{{$usr->servidor}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>{{$usuarios->links()}}</div>
@endsection