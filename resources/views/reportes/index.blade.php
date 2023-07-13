<link rel="stylesheet" href="{{asset('css/reporte.css?4')}}">

@extends('layouts.plantillabase')
@section('contenido')
    <form action="{{route("rep.recibef")}}" method="post">
        @csrf
        <table>
            <tr>
                <td>
                    <div class="form-group">
                        {{-- <label for="ciudad">Ciudad</label> --}}
                        <select id="ciudad" class="form-control" name="ciudad">
                            <option value="">Elige ciudad</option>
                            <option value="CBBA">CBBA</option>
                            <option value="SCZ">SCZ</option>
                            <option value="LPZ">LPZ</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        {{-- <label for="mes">Mes</label> --}}
                        <select id="mes" class="form-control" name="mes">
                            <option value="">Elige mes</option>
                            <option value="1">Enero</option><option value="2">Febrero</option><option value="3">Marzo</option><option value="4">Abril</option><option value="1">Enero</option><option value="1">Enero</option><option value="1">Enero</option><option value="1">Enero</option><option value="1">Enero</option><option value="1">Enero</option><option value="1">Enero</option><option value="1">Enero</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        {{-- <label for="ano">Año</label> --}}
                        <select id="ano" class="form-control" name="ano">
                            <option value="2021" selected>2021</option><option value="2022">2022</option><option value="2023">2023</option>
                        </select>
                    </div>
                </td>
                <td><input type="submit" value="Elegir" class="btn btn-warning"></td>
            </tr>
        </table>
    </form>
    <hr>
    {{-- @if((count($todo)==0)&&(isset($ciudad)))
        <div>Buscando info, filtrando, armando reporte....</div>
    @endif --}}
    @if(count($todo)>0)
    <h3>Reporte de {{$ciudad}}, {{$mes}} {{$ano}}</h3>
    <table class="table table-light">
        <thead class="thead-light">
	     <tr>
                <th></th>
                @foreach ($todo[0]["categorias"] as $unacat)
                    <th colspan="{{count($unacat["marcas"])*2+1}}" class="categorias">{{$unacat["cat"]}}</th>
                @endforeach
               
            </tr>
            <tr>
                <th>Sala</th>
                
                @foreach ($todo[0]["categorias"] as $unacat)
                    @foreach ($unacat["marcas"] as $j=>$unamarca)
                        @if($j==0)
                        <th class="marca">{{$unamarca->marca}}</th>
                        @else
                        <th>{{$unamarca->marca}}</th>
                        @endif
                    @endforeach
                    <th>Total</th>
                    @foreach ($unacat["marcas"] as $j=>$unamarca)
                        @if($j==0)
                        <th class="marcasos">SOS<br>{{$unamarca->marca}}</th>
                        @else
                        <th class="marcasos">SOS<br>{{$unamarca->marca}}</th>
                        @endif
                    @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($todo as $unreg)
                <tr>
                    <td nowrap>{{$unreg["sala"]}}</td>
                    @foreach ($unreg["categorias"] as $unacat)
                        @foreach ($unacat["marcas"] as $unamarca)
                            <td class="caras" title="{{$unreg["sala"]}}">{{$unamarca->caras}}</td>
                        @endforeach
                        <td class="total"  title="{{$unreg["sala"]}}">{{$unacat["total"]}}</td>
                        @foreach ($unacat["marcas"] as $unamarca)
                            <td class="carasos" title="{{$unreg["sala"]}}">{{$unamarca->porcentaje}}%</td>
                        @endforeach
                    @endforeach
                </tr>                
            @endforeach
            <tr class="totales">
                <td>Totales</td>
                @foreach ($totales as $key=>$untotal)
                    @if($key<$limite)
                    <td>{{$untotal}}</td>
                    @endif
                @endforeach

            </tr>
        </tbody>
    </table>
    @endif
        {{-- \\\\\\\\\\\\\\\\\\\\\TABLA MES ANTERIOR \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\--}}
        @if(count($todox)>0)
        <h3>Reporte de {{$ciudad}}, {{$mesx}} {{$anox}}</h3>
        <table class="table table-light">
            <thead class="thead-light">
             <tr>
                    <th></th>
                    @foreach ($todox[0]["categorias"] as $unacat)
                        <th colspan="{{count($unacat["marcas"])*2+1}}" class="categorias">{{$unacat["cat"]}}</th>
                    @endforeach
                   
                </tr>
                <tr>
                    <th>Sala</th>
                    
                    @foreach ($todox[0]["categorias"] as $unacat)
                        @foreach ($unacat["marcas"] as $j=>$unamarca)
                            @if($j==0)
                            <th class="marca">{{$unamarca->marca}}</th>
                            @else
                            <th>{{$unamarca->marca}}</th>
                            @endif
                        @endforeach
                        <th>Total</th>
                        @foreach ($unacat["marcas"] as $j=>$unamarca)
                            @if($j==0)
                            <th class="marcasos">SOS<br>{{$unamarca->marca}}</th>
                            @else
                            <th class="marcasos">SOS<br>{{$unamarca->marca}}</th>
                            @endif
                        @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($todox as $unreg)
                    <tr>
                        <td nowrap>{{$unreg["sala"]}}</td>
                        @foreach ($unreg["categorias"] as $unacat)
                            @foreach ($unacat["marcas"] as $unamarca)
                                <td class="caras" title="{{$unreg["sala"]}}">{{$unamarca->caras}}</td>
                            @endforeach
                            <td class="total"  title="{{$unreg["sala"]}}">{{$unacat["total"]}}</td>
                            @foreach ($unacat["marcas"] as $unamarca)
                                <td class="carasos" title="{{$unreg["sala"]}}">{{$unamarca->porcentaje}}%</td>
                            @endforeach
                        @endforeach
                    </tr>                
                @endforeach
                <tr class="totales">
                    <td>Totales</td>
                    @foreach ($totalesx as $key=>$untotal)
                        @if($key<$limitex)
                        <td>{{$untotal}}</td>
                        @endif
                    @endforeach
    
                </tr>
            </tbody>
        </table>
        @endif
        {{-- \\\\\\\\\\\\\\\\\\\\\\TERMINA MES ANTERIOR\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ --}}
@endsection