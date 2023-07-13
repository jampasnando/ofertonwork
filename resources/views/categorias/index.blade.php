@extends('layouts.plantillabase')
@section('contenido')
    <h3>Categorías</h3>
    <a href="{{route('cats.export')}}" class="btn btn-warning">Exportar a Excel</a>
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cats as $cat)
            <tr>
                <td>{{$cat->id}}</td>
                <td>{{$cat->categoria}}</td>
                <td>{{$cat->estado}}</td>
            </tr>
                
            @endforeach
        </tbody>
    </table>
@endsection