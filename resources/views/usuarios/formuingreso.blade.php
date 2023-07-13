@extends('layouts.plantillalogin')
@section('contenido')
<div class="nuevoprod">
   
    @if (session("guardado"))
            <div class="alert alert-success">{{session("guardado")}}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
               
            </div>
        @endif
        <p></p>
        <p></p>
    <h1 class="card-header">Ingreso</h1> <br>   
    <form action="{{route('validausr')}}" method="post" id="formuventa">
        @csrf
        
        <div class="complementos">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Login</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="login" name="login" aria-describedby="inputGroup-sizing-sm" autocomplete="off">
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Password</span>
                <input type="password" class="form-control" id="password" name="password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
             
           
        </div>
        <div class="col-12" style="text-align: center">
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </div>
    </form>
        
</div>
@endsection