@extends('layouts.plantillabase')
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <div class="titulo"><h3>Marcas</h3></div>
        <div class="botonesheader"><div><a href="{{route("nuevamarca")}}" class="btn btn-success">Nueva Marca</a></div><div>{{$lista->links()}}</div></div>
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>N</th>
                    <th>Nombre</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $unamarca)
                    <tr>
                        <td>{{$unamarca->id}}</td>
                        <td>{{$unamarca->nombre}}</td>
                        <td><a href="{{route('editamarca',$unamarca->id)}}" class="btn btn-secondary">Editar</a></td>
                        <td>
                            <form action="{{route('eliminamarca',$unamarca->id)}}" method="post">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Está seguro de eliminar esta marca?s')" >Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{$lista->links()}}</div>
@endsection