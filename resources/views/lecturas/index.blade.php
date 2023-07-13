@extends('layouts.plantillabase')
@section('contenido')
    <h3>Lecturas</h3>
        <a href="{{route("lec.export")}}" class="btn btn-warning">Exportar a Excel</a>
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Lider</th>
                    <th>Sala</th>
                    <th>Marca</th>
                    <th>Caras</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>FechaRegistro</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lecturas as $lec)
                    <tr>
                        <td>{{$lec->id}}</td>
                        <td>{{$lec->lider}}</td>
                        <td>{{$lec->sala}}</td>
                        <td>{{$lec->marca}}</td>
                        <td>{{$lec->caras}}</td>
                        <td>{{$lec->fecha}}</td>
                        <td>{{$lec->estado}}</td>
                        <td>{{$lec->fechareg}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{$lecturas->links()}}</div>
@endsection