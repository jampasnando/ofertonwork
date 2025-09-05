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
                        <td>
                            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalpago" onclick="llenapago('{{$unregistro->proveedor}}')">Pago</a>
                            <a href="{{route("compras.detdeudas",["proveedor"=>$unregistro->proveedor])}}" class="btn btn-warning">Detalle</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
          {{-- ////////////////////////////////////           MODAL PAGO                 ////////////////////////// --}}
          {{-- <button style="display:none;" id="btnpago" data-bs-toggle="modal" data-bs-target="#modalpago"></button> --}}
          <div class="modal fade" id="modalpago" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-body p-8" style="background: #fff6b740;">
                    <div class="position-absolute top-0 end-0 me-3 mt-3 z-3" style="border: 2px solid red;top: -1.5em !important;border: 2px solid red;right: -1.5em !important;background: white;">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route("compras.registrapago")}}" method="post" id="formupago">
                        @csrf
                        <div class="input-group mb-3" style="justify-content:center" id="nuevopago">
                            <div style="color:red;">Pagar a <span id="nombreproveedor" style="font-weight: bold">nombreproveedor</span></div>
                            <table>
                                <tr>
                                    <th>Monto</th>
                                    <th>TipoPago</th>
                                    <th>Nro Nota</th>
                                    <th>Observacion</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="number" class="form-control bg-light" id="monto" name="monto" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </td>
                                    <td>
                                        <select class="form-select" aria-label="Default select example" id="tipopago" name="tipopago" >
                                            <option value="contado">Efectivo</option>
                                            <option value="tarjeta">Tarjeta</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="deposito">Depósito</option>
                                            <option value="transferencia">Transferencia</option>
                                        </select>
                                    </td>
                                    <td style="background: snow">
                                        <input type="text" class="form-control bg-light" id="nronota" name="nronota" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </td>
                                    <td style="background: snow">
                                        <input type="text" class="form-control bg-light" id="observacion" name="observacion" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </td>
                                    <td><button class="btn btn-secondary" type="submit">Registrar nuevo pago</button></td>
                                </tr>
                            </table>
                            {{-- <input type="hidden" name="idcompra" name="idcompra" value="{{$compra->idcompra}}">
                            <input type="hidden" name="id" name="id" value="{{$compra->id}}"> --}}
                            <input type="hidden" name="proveedor" id="proveedor" value="">
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
          {{-- //////////////////////////////////////////////////////////////////////////////////// --}}   
        
@endsection
<script>
    window.onload=function(){
        tb=document.getElementById("tb_deudas");
        totaliza();
    }
    function llenapago(proveedor){
        console.log(proveedor);
        document.getElementById("nombreproveedor").innerText=proveedor;
        document.getElementById("proveedor").value=proveedor;
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