@extends('layouts.plantillabase')
@section('contenido')
    
<h3>Salas</h3>
<a href="{{route('salas.export')}}" class="btn btn-warning">Exportar a Excel</a>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Ciudad</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salas as $sala)
            <tr>
                <td>{{$sala->id}}</td>
                <td>{{$sala->nombre}}</td>
                <td>{{$sala->ciudad}}</td>
                <td>{{$sala->estado}}</td>
            </tr>
        @endforeach
        
    </tbody>
</table>
<div class="paginacion">{{$salas->links()}}</div>
@endsection