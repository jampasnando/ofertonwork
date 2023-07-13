@extends("layouts.plantillabase")
@section("contenido")
<h1>Pagina Index</h1>
<a href="articulo/create" class="btn btn-warning">Crear</a>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Codigo</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($articulos as $articulo)
        <tr>
            <td>{{$articulo->id}}</td>
            <td></td>
            <td>{{$articulo->codigo}}</td>
            <td>{{$articulo->descripcion}}</td>
            <td>{{$articulo->cantidad}}</td>
            <td>{{$articulo->Precio}}</td>
            <td>
                <a href="" class="btn btn-info">Editar</a>
                <button class="btn btn-danger">Eliminar</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection