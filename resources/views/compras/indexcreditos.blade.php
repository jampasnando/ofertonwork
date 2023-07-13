@extends(session("usr")->rol=="Enc. Tienda y caja"?"layouts.plantillavendedor":'layouts.plantillabase') 
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <br>
        <div class="titulo"><h3>Resumen Deudas <span style="color:darkorange"> SumaDeudas: </span><span style="color:darkorange" id="total"></span></h3></div>

        <table class="table table-light " id="tb_deudas">
            <thead class="thead-light">
                <tr>
                    <th>N</th>
                    <th>Proveedor</th>
                    <th>Total</th>
                    <th>Pagado</th>
                    <th>Deuda</th>
                    <th>Ultimo Pago</th>
                    <th>DiasTranscurridos</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $key=>$unregistro)
                    <tr >
                        <td>{{$loop->iteration}}</td>
                        <td>{{$unregistro->proveedor}}</td>
                        <td>{{round($unregistro->total,2)}}</td>
                        <td>{{round($unregistro->pagado,2)}}</td>
                        <td>{{round($unregistro->total) - $unregistro->pagado,2}}</td>
                        @if ($unregistro->ultfecha!=null)
                        <td>{{implode("-",array_reverse(explode("-",explode(" ",$unregistro->ultfecha)[0])))." ".explode(" ",$unregistro->ultfecha)[1]}}</td>
                        @else 
                        <td></td>
                        @endif
                        <td>{{$unregistro->dias}}</td>
                        <td><a href="{{route("compras.detdeudas",["proveedor"=>$unregistro->proveedor])}}" class="btn btn-warning">Detalle</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
@endsection
<script>
    window.onload=function(){
        tb=document.getElementById("tb_deudas");
        totaliza();
    }
    function totaliza(){
        tb=document.getElementById("tb_deudas");
        nrofilas=tb.rows.length-1;
        totalacumulados=0;
        totalpagados=0;
        for(k=1;k<nrofilas;k++){
                unpagado=tb.rows[k].cells[3].innerText;
                if(unpagado==""){unpagado=0;}
                totalacumulados=totalacumulados + parseFloat(tb.rows[k].cells[2].innerText);
                totalpagados=totalpagados + parseFloat(unpagado);
        }
        document.getElementById("total").innerText=(totalacumulados-totalpagados).toFixed(2);
    }
</script>