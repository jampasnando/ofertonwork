@extends('layouts.plantillasaldos')
@section('contenido')
<div class="nuevoprod">
   
    <h1 class="card-header">Saldos</h1> <br>   
    <form action="" method="post" id="formuventa">
        @csrf
        <div class="cabeceraventa">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Deposito</span>
                <select class="form-select" aria-label="Default select example" id="deposito" style="background: aliceblue">
                    @foreach ($depositos as $undepot)
                        <option value="{{$undepot->id}}">{{$undepot->nombre}}</option>
                    @endforeach
                </select>
                {{-- ////////////////////////////////////////////////// --}}
                {{-- <div class="input-group mb-3">
                    <div class="input-group mb-3">
                        <input type="hidden" name="idvendedor" id="idvendedor" value='132'>
                        <span class="input-group-text" id="basic-addon2">Vendedor</span>
                        <input type="text" class="form-control" placeholder="Buscar vendedor" id="vendedor" style="background: lightyellow" value="Tienda Cbba">
                        <a href="" class="btn btn-secondary" id="borrarvendedor" style="display:none" onclick="borrarvendedor(event)">X</a>
                        <div class="resultadobusq2" id="resultadobusq2"></div>
                    </div>
                    
                </div> --}}
                {{-- ////////////////////////////////////////////////// --}}
            </div>
            
            
        </div>
        
    
    <br>
    <div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar producto" id="texto" autofocus>
            <a href="" class="btn btn-secondary" id="borrar" style="display:none" onclick="borrar(event)">X</a>
            <span class="input-group-text" id="basic-addon2">Buscar</span>
            <div class="resultadobusq" id="resultadobusq"></div>
        </div>
        <table class="table table-stripped table-hover" id="detalleventa" >
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">Cotizar</th>
                <th scope="col">Subtotal</th>
                <th></th>
                <th scope="col" style="text-align:right">Comision</th>
              </tr>
            </thead>
            <tbody>
             
            </tbody>
          </table>
          <table class="table">
              {{-- <tr><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="text-align:right;font-weight:bold;font-size:1.5em">0</td><td></td><td></td></tr> --}}
              <tr><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: <span id="total">0</span></td><td></td><td></td></tr>

          </table>
          
    </div >
    <br>
        {{-- <div class="complementos">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">*Cliente</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="cliente" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO">
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">NIT</span>
                <input type="text" class="form-control" id="nit" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Pago con</span>
                <select class="form-select" aria-label="Default select example" id="formapago">
                    <option value="contado">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="cheque">Cheque</option>
                    <option value="deposito">Depósito</option> 
                </select>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Comentario</span>
                <input type="text" class="form-control" id="comentario" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
        </div> --}}
    </form>
        {{-- <div class="col-12" style="text-align: center">
            <a href="{{route('ventas.index')}}" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-primary" onclick="guardaventa()">Registrar Venta</button>
        </div> --}}
</div>
<script>
    window.addEventListener("load",function(){
        console.log("pagina cargada");
        casbusq=document.getElementById("texto");
        casbusq.addEventListener("keyup",function(){
            dep=document.getElementById("deposito").value;
            console.log("dep: ",dep);
            document.getElementById("resultadobusq").innerHTML="Buscando...";
            if(casbusq.value.length>1){
                document.getElementById("borrar").style="display:block";
                fetch("buscaprodsolosaldos?texto="+casbusq.value+"&dep="+dep,{method:"get"})
                .then(response=>response.text())
                .then(datos=>{
                    if(datos.length>0){
                        document.getElementById("resultadobusq").innerHTML=datos;
                    }
                    else{
                        document.getElementById("resultadobusq").innerHTML="No hallado";
                    }
                
                });
            }
            else{
                document.getElementById("resultadobusq").innerHTML="";
            }
        });
        // casbusq2=document.getElementById("vendedor");
        // casbusq2.addEventListener("keyup",function(){
        //     if(casbusq2.value.length>1){
        //         document.getElementById("borrarvendedor").style="display:block";
        //         fetch("buscavendedor?vendedor="+casbusq2.value,{method:"get"})
        //         .then(response=>response.text())
        //         .then(datos=>{
        //             document.getElementById("resultadobusq2").style.display="block";
        //             document.getElementById("resultadobusq2").innerHTML=datos;
        //         });
        //     }
        //     else{
        //         document.getElementById("resultadobusq2").style.display="none";
        //         document.getElementById("resultadobusq2").innerHTML="";
        //     }
        // });
        // casbusq2.addEventListener("blur",function(){
        //     if(casbusq2.value.length==0){
        //         borrarvendedor(event);
        //     }
        // });
       
    });
    function guardaventa(){
        
        tabla=document.getElementById("detalleventa");
        nrofilas=tabla.rows.length;
        if(nrofilas==1 || document.getElementById("cliente").value==""){
            alert("Formulario Incompleto \r\nDebe haber al menos un producto en venta y el cliente no puede estar en blanco");
        }
        else{
            dataenvio=[];
            prods=[];
            for(i=1;i<nrofilas;i++){
                unprod={idprod:tabla.rows[i].cells[0].querySelector("input").value,preciolocal:tabla.rows[i].cells[1].querySelector("input").value,precioventa:tabla.rows[i].cells[5].querySelector("input:first-child").value,preciofinal:tabla.rows[i].cells[2].querySelector("input").value,cuantos:tabla.rows[i].cells[3].querySelector("input").value,descripcion:"",comision:tabla.rows[i].cells[5].querySelector("input:nth-child(2)").value,vendedor:document.getElementById("idvendedor").value,descripcion:tabla.rows[i].cells[1].innerText};
                prods.push(unprod);
            }
            dataenvio=[{cliente:document.getElementById("cliente").value,nit:document.getElementById("nit").value,vendedor:document.getElementById("idvendedor").value,detalleventa:prods,total:document.getElementById("total").innerText,idusr:"100",formapago:document.getElementById("formapago").value,comentario:document.getElementById("comentario").value,idneg:document.getElementById("deposito").value}];
            // dataenvio=[{clientes:[{nombre:"pedro gomez",pais:"bolivia"},{nombre:"jaime",pais:"peru"}]}];
            console.log("venta a guardar: ",dataenvio);
            fetch('guardanuevaventa', {
            method: 'post',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            credentials: "same-origin",
            body: JSON.stringify(dataenvio)
            })
            .then(res => res.json())
            .then(res => {
                console.log("desdeBD: ",res);
                alert("VENTA REGISTRADA");
                tabladet=document.getElementById("detalleventa");
                document.getElementById("formuventa").reset();
                while(tabladet.rows.length>1){
                    tabladet.deleteRow(-1);
                }
                // window.location.replace("{{route('nuevaventa')}}");
            });
        }
        
    }
    function elegido(id,descr,precioventa,preciolocal,comision,cantidad){
        console.log(id,descr);
        tabla=document.getElementById("detalleventa");
        nro=tabla.rows.length;
        fila=tabla.insertRow();
        celda=fila.insertCell();
        celda.innerHTML="<span style='color:red;cursor:pointer' onclick='elimina(this)'>X</span>&nbsp" + nro+"<input type='hidden' value='"+id+"' name='id_"+nro+"' id='id_"+nro+"'>";
        celda=fila.insertCell();
        celda.innerHTML="<span>[ "+cantidad+" ]</span>" + descr + "<input type='hidden' value='"+preciolocal+"' name='pc_"+nro+"' id='pc_"+nro+"'>";
        if(parseFloat(cantidad)<=0){
            celda.style.color="red";
        }
        celda=fila.insertCell();
        celda.style.width="9em";
        celda.innerHTML="<input type='number' value='"+precioventa+"' name='pfinal_"+nro+"' id='pfinal_"+nro+"' onchange='cambiacant(this)'  class='form-control' style='text-align:right'>";
        celda=fila.insertCell();
        celda.style.width="7em";
        celda.innerHTML="<input type='number' value='1' name='c_"+nro+"' id='c_"+nro+"' onchange='cambiacant(this)'  class='form-control' style='text-align:center'>";
        celda=fila.insertCell();
        celda.style.textAlign="right";
        celda.innerText=precioventa;
        celda=fila.insertCell();
        celda.innerHTML="<input type='hidden' value='"+precioventa+"' name='pv_"+nro+"' id='pv_"+nro+"'><input type='hidden' value='"+comision+"' name='com_"+nro+"' id='com_"+nro+"'>";
        celda=fila.insertCell();
        celda.innerHTML="<input type='number' value='"+comision+"' name='comi_"+nro+"' id='comi_"+nro+"' class='form-control' style='text-align:right'>";
        document.getElementById("resultadobusq").innerHTML="";
        document.getElementById("texto").value="";
        calculatotal();
    }
    function elimina(prod){
        
        fila=prod.parentElement.parentElement.rowIndex;
        document.getElementById("detalleventa").deleteRow(fila);
    }
    function vendedorelegido(id,nombre){
        document.getElementById("vendedor").value=nombre;
        document.getElementById("idvendedor").value=id;
        document.getElementById("resultadobusq2").innerHTML="";
        document.getElementById("borrarvendedor").style="display:none";
        document.getElementById("resultadobusq2").style.display="none";

    }
    function cambiacant(input){
        celda=input.parentElement;
        fila=celda.parentElement;
        fila.cells[4].innerText=fila.cells[2].querySelector("input").value * fila.cells[3].querySelector("input").value ;
        console.log("nuevacant: ",input.value);
        calculatotal();
    }
    function calculatotal(){
        total=0;
        tabla=document.getElementById("detalleventa");
        nro=tabla.rows.length;
        for(k=1;k<nro;k++){
            total=total + tabla.rows[k].cells[4].innerText*1;
        }
        document.getElementById("total").innerText=total;
    }
    function borrar(e){
        e.preventDefault();
        document.getElementById("texto").value="";
        document.getElementById("borrar").style="display:none";
        document.getElementById("resultadobusq").innerHTML="";
    }
    function borrarvendedor(e){
        e.preventDefault();
        document.getElementById("resultadobusq2").style.display="none";
        document.getElementById("vendedor").value="Tienda";
        document.getElementById("idvendedor").value="136";
        document.getElementById("borrarvendedor").style="display:none";
        document.getElementById("resultadobusq2").innerHTML="";
    }
    function irareporte(){
        console.log("entraareportevendedor");
        carnet=document.getElementById("carnet").value;
        if(carnet!=""){
            document.getElementById("elcarnet").value=carnet;
            document.getElementById("formcarnet").submit();
        }
        
    }
</script>
@endsection
