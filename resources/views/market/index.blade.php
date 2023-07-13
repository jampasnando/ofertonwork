@extends("layouts.plantillamarket")
@section("contenido")
<div class="row">
  <!-- col -->
  <div class="col-12">
    <!-- cta -->
    <div
      class="bg-light d-lg-flex justify-content-between align-items-center py-6 py-lg-3 px-8 text-center text-lg-start rounded">
      <!-- img -->
      <div class="d-lg-flex align-items-center">
        {{-- <img src="../assets/images/about/about-icons-1.svg" alt="" class="img-fluid"> --}}
        <!-- text -->

        <div class="ms-lg-4">
          <h1 class="fs-2 mb-1">Bienvenido a Ferreterías Ofertón</h1>
          <span>Le invitamos a instalar en su celular nuestra APP <span class="text-primary">OFERTÓN</span>
            para IOs o Android.</span>

        </div>

      </div>
      <div class="mt-3 mt-lg-0 app">
        <!-- btn -->
        <a href="#" class="btn btn-dark"><img src="{{url('/imagenes/appstore-btn.svg')}}" alt=""></a>
        <a href="#" class="btn btn-dark"><img src="{{url('/imagenes/googleplay-btn.svg')}}" alt=""></a>
      </div>
    </div>
  </div>

</div>
<div class="espacio"></div>
<div class="ancho">



</div>

<section>
  <div>
    <!-- row -->
    <div class="row">
      <div class="col-12 mb-6">
        <!-- heading -->
        <h3 class="mb-1" id="titulocategoria">Todas las Categorías</h3>
        <p class="mb-0" id="titulomarca">Todas las Marcas</p>

      </div>
    </div>
    @php
    $contfilas=0;
    $contcols=0;
    $nroprods=count($prods);
    $nrofilas=(int)$nroprods/5;
    $residuo=$nroprods % 5;
    @endphp
    <div id="productos">
    <div class="row">
      @foreach ($prods as $unprod)
      @if ($contcols<5) <div class="col">
        <div class="item">
          <div class="card card-product" style="height: 100%">
            <div class="card-body">
              <div class="text-center position-relative ">
                <a href="#!"> <img src="{{url('/images/'.$unprod->imagenes)}}" alt="Ferreterías Ofertón"
                    class="mb-3 img-fluid" data-bs-toggle="modal" data-bs-target="#detalleUnProd"
                    onclick="llenamodalini({{json_encode($unprod)}})">
                </a>
              </div>
              <div class="text-small mb-1"><a href="#!"
                  class="text-decoration-none text-muted"><small>{{$unprod->descripcion}}</small></a></div>
              <h2 class="fs-6"><a href="#!" class="text-inherit text-decoration-none">{{$unprod->marca}}</a>
              </h2>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <div><span class="text-dark" style="font-weight: bold">Bs.{{$unprod->precioventa}}</span> <span
                    class="text-decoration-line-through text-muted">Bs.{{($unprod->precioventa +
                    (int)$unprod->precioventa*0.1)}}</span>
                </div>
                <div><a href="#!" class="btn btn-sm" style="background:limegreen;color:white;" onclick="llenamodalini({{json_encode($unprod)}})" data-bs-toggle="modal" data-bs-target="#detalleUnProd">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="feather feather-plus">
                      <line x1="12" y1="5" x2="12" y2="19"></line>
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg> Añadir</a></div>
              </div>
            </div>
          </div>
        </div>
        <!-- item -->
    </div>
    @php
    $contcols++;
    @endphp
    @else
  </div>
  <div class="espacio"></div>
  <div class="row">
    <div class="col">
      <div class="item">
        <div class="card card-product" style="height: 100%;">
          <div class="card-body">
            <div class="text-center position-relative ">
              <a href="#!"> <img src="{{url('/images/'.$unprod->imagenes)}}" alt="Ferreterías Ofertón"
                class="mb-3 img-fluid" data-bs-toggle="modal" data-bs-target="#detalleUnProd"
                onclick="llenamodalini({{json_encode($unprod)}})">
            </a>
            </div>
            <div class="text-small mb-1"><a href="#!"
                class="text-decoration-none text-muted"><small>{{$unprod->descripcion}}</small></a></div>
            <h2 class="fs-6"><a href="#!" class="text-inherit text-decoration-none">{{$unprod->marca}}</a>
            </h2>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <div><span class="text-dark" style="font-weight: bold">Bs.{{$unprod->precioventa}}</span> <span
                  class="text-decoration-line-through text-muted">Bs.{{$unprod->precioventa +
                  (int)$unprod->precioventa*0.1}}</span>
              </div>
              <div><a href="#!" class="btn btn-sm" style="background:limegreen;color:white;" onclick="llenamodalini({{json_encode($unprod)}})" data-bs-toggle="modal" data-bs-target="#detalleUnProd">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-plus">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                  </svg> Añadir</a></div>
            </div>
          </div>
        </div>
      </div>
      <!-- item -->
    </div>
    @php
    $contcols=1;
    @endphp
    @endif

    @endforeach
    @while ($residuo<5 && $residuo>0)
    <div class="col"></div>
    @php
    $residuo++;
    @endphp
    @endwhile
    
  </div>
  </div>
    <div class="mas" style="width: 100%;text-align:right;margin:1em 0;">
      <button class="btn btn-success border" onclick="mas()">MAS...</button>
    </div>
  </div>

  {{-- ////////////////////////////////////MODAL DETALLE UN PROD ////////////////////////// --}}
  <div class="modal fade" id="detalleUnProd" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-8" style="background: #fff6b740;">
          <div class="position-absolute top-0 end-0 me-3 mt-3">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <!-- img slide -->
              <div class="tns-outer" id="productModal-ow">
                {{-- <div class="tns-liveregion tns-visually-hidden" aria-live="polite" aria-atomic="true">slide <span
                    class="current">1</span> of 4
                </div> --}}
                <div id="productModal-mw" class="tns-ovh">
                  <div class="tns-inner" id="productModal-iw">
                    <div class="product productModal  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal"
                      id="productModal" style="transition-duration: 0s; transform: translate3d(0%, 0px, 0px);">
                      <div class="zoom tns-item tns-slide-active" onmousemove="zoom(event)"
                        style="background-position: 99.0494% 42.7848%;"
                        id="productModal-item0">
                        <!-- img -->
                        <img src="" alt="" style="width: 100%;height:100%;">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="ps-lg-8 mt-6 mt-lg-0">
                <a href="#!" class="mb-4 d-block" id="modal_marca" style="text-decoration: none;color:forestgreen;font-weight:bold"></a>
                <h4 class="mb-1 h4" id="modal_descripcion"></h4>
                <div class="mb-4">
                  <small class="text-warning">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i></small><a href="#" class="ms-2"></a>
                </div>
                <div class="fs-4">
                  <span class="fw-bold text-dark" id="modal_precio"></span>
                  <span class="text-decoration-line-through text-muted" id="modal_precioantes"></span><span><small
                      class="fs-6 ms-2 text-danger" id="modal_descuento"></small></span>
                </div>
                <hr class="my-6">
                <div>
                  <div class="input-group input-spinner  ">
                    <input type="button" value="-" class="button-minus  btn  btn-sm btncuantos" data-field="quantity" onclick="document.getElementById('cuantos').value>1?document.getElementById('cuantos').value--:true;">
                    <input type="number" step="1" value="1" name="quantity" class="quantity-field form-control-sm form-input" style="width: 4em;" id="cuantos">
                    <input type="button" value="+" class="button-plus btn btn-sm btncuantos" data-field="quantity" onclick="document.getElementById('cuantos').value++;">
                  </div>
                </div>
                <div class="mt-3 row justify-content-start g-2 align-items-center">

                  <div class="col-lg-4 col-md-5 col-6 d-grid">
                    <button type="button" class="btn" style="background: limegreen;color:white;" id="btnanadiralcarrito" data-bs-dismiss="modal">
                      <i class="feather-icon icon-shopping-bag me-2"></i>Añadir al Carrito
                    </button>
                  </div>
                  <div class="col-md-4 col-5">
                    <button type="button" class="btn" style="background: limegreen;color:white;" id="btnpagarahora" data-bs-dismiss="modal">
                      <i class="feather-icon icon-shopping-bag me-2"></i>Pagar ahora
                    </button>
                    {{-- <select class="form-select" style="background: gold;font-weight:bold" onchange="comprar(this)">
                      <option selected="selected" value=''>Pagar Ahora</option>
                      <option value='qr'>Pagar con QR</option>
                      <option value='tarjeta'>Pagar con Tarjeta</option>
                      <option value='transferencia'>Pagar con Transferencia</option>
                    </select> --}}
                  </div>
                </div>
                <hr class="my-6">
                <div>
                  <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td>Código de Producto:</td>
                        <td id="modal_codprod"></td>
                      </tr>
                      <tr>
                        <td>Disponibles:</td>
                        <td id="modal_stock"></td>
                      </tr>
                      <tr>
                        <td>Categoría:</td>
                        <td id="modal_categoria"></td>
                      </tr>
                      <tr>
                        <td>Entregas:</td>
                        <td>
                          <small>Por Delivery ó recojo en Ferretería.<span class="text-muted">( Delivery gratis hoy )</span></small>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- //////////////////////////////////////////////////////////////////////////////////// --}}

          {{-- //////////////////////////////////// MODAL CIUDADES--}}
          <div class="modal fade" id="modalCiudades" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
              <div class="modal-content">
                 <div class="modal-body p-6">
                    <div class="d-flex justify-content-between align-items-start ">
                       <div>
                          <h5 class="mb-1" id="locationModalLabel">SUCURSALES</h5>
                          <p class="mb-0 small">Si tu producto está en otra sucursal, te la hacemos llegar sin costo de traslado. </p>
                       </div>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div>
                       <div data-simplebar >
                          <div class="list-group list-group-flush">
                             <a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action" onclick="sucursal=1;buscar='';document.getElementById('sucursal').innerText='Cochabamba';porajax();" data-bs-dismiss="modal"><span>Cochabamba</span></a>
                             <a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action" onclick="sucursal=2;buscar='';document.getElementById('sucursal').innerText='Santa Cruz';porajax();" data-bs-dismiss="modal"><span>Santa Cruz</span></a>
                             <a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action" onclick="sucursal=3;buscar='';document.getElementById('sucursal').innerText='La Paz';porajax();" data-bs-dismiss="modal"><span>La Paz</span></a>
                             <a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action" onclick="sucursal=7;buscar='';document.getElementById('sucursal').innerText='El Alto';porajax();" data-bs-dismiss="modal"><span>El Alto</span></a>
                             <a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action" onclick="sucursal=4;buscar='';document.getElementById('sucursal').innerText='Oruro';porajax();" data-bs-dismiss="modal"><span>Oruro</span></a>
                             <a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action" onclick="sucursal=0;buscar='';document.getElementById('sucursal').innerText='Todas las Sucursales';porajax();" data-bs-dismiss="modal"><span>Todas las Sucursales</span></a>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
          </div>
          {{-- ///////////////////////////////////// --}}


    {{-- ////////////////////////////////////MODAL CARRITO ////////////////////////// --}}
  <div class="modal fade" id="modalCarrito" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-8" style="background: #fff6b740;">
          <div class="position-absolute top-0 end-0 me-3 mt-3">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="row">
            <h4 class="mb-1 h4" id="modal_descripcion">Contenido de tu Carrito</h4>
            <div class="col-lg-7" id="itemscarrito">
            </div>
            <div class="col-lg-5">
              <div class="ps-lg-8 mt-6 mt-lg-0">
                <h5 style="color:limegreen">Pago</h5>
                <div class="mb-4">
                  <a href="#" class="ms-2"></a>
                </div>
                <div class="fs-4">
                  <span class="fw-bold text-dark" id="modal_precio"></span>
                  <span class="text-decoration-line-through text-muted" id="modal_precioantes"></span><span><small
                      class="fs-6 ms-2 text-danger" id="modal_descuento"></small></span>
                </div>
                <hr class="my-6">
                
                <div class="mt-3 row justify-content-start g-2 align-items-center">

                  {{-- <div class="col-lg-4 col-md-5 col-6 d-grid">
                    <button type="button" class="btn" style="background: limegreen;color:white;">
                      <i class="feather-icon icon-shopping-bag me-2"></i>Añadir al Carrito
                    </button>
                  </div> --}}
                  <div class="col-md-5 col-5">
                    <select class="form-select" style="background: gold;font-weight:bold" onchange="comprar(this)">
                      <option selected="selected" value=''>Pagar con...</option>
                      <option value='qr'>Pagar con QR</option>
                      <option value='tarjeta'>Pagar con Tarjeta</option>
                      <option value='transferencia'>Pagar con Transferencia</option>
                    </select>
                  </div>
                </div>
                <hr class="my-6">
                <div>
                  <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td>Entregas:</td>
                        <td>
                          <small>Por Delivery ó recojo en Ferretería.<span class="text-muted">( Delivery gratis hoy )</span></small>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- //////////////////////////////////////////////////////////////////////////////////// --}}       
          @csrf
</section>

@endsection
<script>
  marca="Todas";
  sucursal=0;
  categoria="Todas";
  unprod=null;
  buscar="";
  limite=0;
  aumentahtml=false;
  carrito=[];
  function zoom(f){var t=f.currentTarget;offsetX=f.offsetX||f.touches[0].pageX,f.offsetY?offsetY=f.offsetY:offsetX=f.touches[0].pageX,x=offsetX/t.offsetWidth*100,y=offsetY/t.offsetHeight*100,t.style.backgroundPosition=x+"% "+y+"%"}
    function llenamodalini(unprod){
      console.log("llenamodalini: ",unprod);
      elobj=document.getElementById("productModal-item0");
      elobj.style.backgroundImage="url('https://ferreteriaoferton.com/ferreteria/public/images/"+unprod.imagenes+"')";
      imgobj=elobj.querySelector("img");
      imgobj.src="https://ferreteriaoferton.com/ferreteria/public/images/"+unprod.imagenes;
      document.getElementById("modal_marca").innerText=unprod.marca;
      document.getElementById("modal_descripcion").innerText=unprod.descripcion;
      document.getElementById("modal_precio").innerText="Bs."+unprod.precioventa;
      document.getElementById("modal_precioantes").innerText=unprod.precioventa + Math.trunc(unprod.precioventa*0.1);
      document.getElementById("modal_descuento").innerText="10% descuento";
      document.getElementById("modal_codprod").innerText=unprod.idprod;
      document.getElementById("modal_stock").innerText=unprod.cantidad;
      document.getElementById('cuantos').value=1;
      document.getElementById("modal_categoria").innerText=unprod.categoria;
      document.getElementById("btnanadiralcarrito").onclick=function(){
        console.log("anadirá: ",unprod);
        unprod.cuantos=document.getElementById('cuantos').value;
        carrito.push(unprod);
        document.getElementById("divcarrito").style.display='';
        document.getElementById("nroitemscarrito").innerText=carrito.length;
      };
      document.getElementById("btnpagarahora").onclick=function(){
        console.log("anadirá: ",unprod);
        unprod.cuantos=document.getElementById('cuantos').value;
        carrito.push(unprod);
        document.getElementById("divcarrito").style.display='';
        document.getElementById("nroitemscarrito").innerText=carrito.length;
        document.getElementById("divcarrito").click();
      };
    }
    function llenamodal(indice){
      console.log("indice: ", indice);
      unprod=listaprods[indice];
      elobj=document.getElementById("productModal-item0");
      elobj.style.backgroundImage="url('https://ferreteriaoferton.com/ferreteria/public/images/"+unprod.imagenes+"')";
      imgobj=elobj.querySelector("img");
      imgobj.src="https://ferreteriaoferton.com/ferreteria/public/images/"+unprod.imagenes;
      document.getElementById("modal_marca").innerText=unprod.marca;
      document.getElementById("modal_descripcion").innerText=unprod.descripcion;
      document.getElementById("modal_precio").innerText="Bs."+unprod.precioventa;
      document.getElementById("modal_precioantes").innerText=unprod.precioventa + Math.trunc(unprod.precioventa*0.1);
      document.getElementById("modal_descuento").innerText="10% descuento";
      document.getElementById("modal_codprod").innerText=unprod.idprod;
      document.getElementById("modal_stock").innerText=unprod.cantidad;
      document.getElementById('cuantos').value=1;
      unprod.cuantos=1;
      document.getElementById("modal_categoria").innerText=unprod.categoria;
      document.getElementById("btnanadiralcarrito").onclick=function(){
        console.log("anadirá: ",unprod);
        unprod.cuantos=document.getElementById('cuantos').value;
        carrito.push(unprod);
        document.getElementById("divcarrito").style.display='';
        document.getElementById("nroitemscarrito").innerText=carrito.length;
      };
      document.getElementById("btnpagarahora").onclick=function(){
        console.log("anadirá: ",unprod);
        unprod.cuantos=document.getElementById('cuantos').value;
        carrito.push(unprod);
        document.getElementById("divcarrito").style.display='';
        document.getElementById("nroitemscarrito").innerText=carrito.length;
        document.getElementById("divcarrito").click();
      };
    }
    function porajax(){

      dataenvio=[{marca:marca,sucursal:sucursal,categoria:categoria,buscar:buscar,limite:limite}];
      console.log("dataenvio: ",dataenvio);
      fetch('obtieneproductos', {
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
                document.getElementById("titulomarca").innerText=marca;
                document.getElementById("titulocategoria").innerText=document.getElementById("categoria").options[document.getElementById("categoria").selectedIndex].text;
                console.log("desdeBD: ",res);
                contfilas=0;
                contcols=0;
                nroprods=res.length;
                nrofilas=Math.trunc(nroprods/5);
                residuo=nroprods % 5;
                listaprods=[];
                contador=0;
                html='<div class="espacio"></div><div class="row">';
                res.forEach(unprod => {
                  console.log("unprod: ",unprod);
                  listaprods.push(unprod);
                  if (contcols<5){
                    html+='<div class="col">';
                    html+='<div class="item"><div class="card card-product" style="height: 100%"><div class="card-body"><div class="text-center position-relative ">';
                    html+='<a href="#!"> <img src="/ferreteria/public/images/'+unprod.imagenes+'" alt="" class="mb-3 img-fluid" data-bs-toggle="modal" data-bs-target="#detalleUnProd" onclick="llenamodal('+contador+');"></a>';
                    html+='</div>';
                    html+='<div class="text-small mb-1"><a href="#!" class="text-decoration-none text-muted"><small>'+unprod.descripcion+'</small></a></div>';
                    html+='<h2 class="fs-6"><a href="#!" class="text-inherit text-decoration-none">'+unprod.marca+'</a>';
                    html+='</h2>';
                    html+='<div class="d-flex justify-content-between align-items-center mt-3">';
                    html+='<div><span class="text-dark" style="font-weight: bold">Bs.'+unprod.precioventa+'</span> <span class="text-decoration-line-through text-muted">Bs.'+(unprod.precioventa*1 + Math.trunc(unprod.precioventa*0.1)*1)+'</span>';
                    html+='</div>';
                    html+='<div><a href="#!" class="btn btn-sm" style="background:limegreen;color:white;" onclick="llenamodal('+contador+');" data-bs-toggle="modal" data-bs-target="#detalleUnProd">';
                    html+='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">';
                    html+='<line x1="12" y1="5" x2="12" y2="19"></line>';
                    html+='<line x1="5" y1="12" x2="19" y2="12"></line>';
                    html+='</svg> Añadir</a></div>';
                    html+='</div>';
                    html+='</div>';
                    html+='</div>';
                    html+='</div>';
                    html+='</div>';
                    contcols++;
                  } 
                  else{
                    html+='</div>';
                    html+='<div class="espacio"></div>';
                    html+='<div class="row">';
                    html+='<div class="col">';
                    html+='<div class="item">';
                    html+='<div class="card card-product" style="height: 100%;">';
                    html+='<div class="card-body">';
                    html+='<div class="text-center position-relative ">';
                    html+='<a href="#!"> <img src="/ferreteria/public/images/'+unprod.imagenes+'" alt="Ferreterías Ofertón" class="mb-3 img-fluid" data-bs-toggle="modal" data-bs-target="#detalleUnProd" onclick="llenamodal('+contador+');">';
                    html+='</a>';
                    html+='</div>';
                    html+=' <div class="text-small mb-1"><a href="#!" class="text-decoration-none text-muted"><small>'+unprod.descripcion+'</small></a></div>';
                    html+='<h2 class="fs-6"><a href="#!" class="text-inherit text-decoration-none">'+unprod.marca+'</a>';
                    html+='</h2>';
                    html+='<div class="d-flex justify-content-between align-items-center mt-3">';
                    html+=' <div><span class="text-dark" style="font-weight: bold">Bs.'+unprod.precioventa+'</span> <span class="text-decoration-line-through text-muted">Bs'+(unprod.precioventa*1 + Math.trunc(unprod.precioventa*0.1)*1)+'</span>';
                    html+='</div>';
                    html+='<div><a href="#!" class="btn btn-sm" style="background:limegreen;color:white;" onclick="llenamodal('+contador+');" data-bs-toggle="modal" data-bs-target="#detalleUnProd">';
                    html+='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">';
                    html+='<line x1="12" y1="5" x2="12" y2="19"></line>';
                    html+='<line x1="5" y1="12" x2="19" y2="12"></line>';
                    html+='</svg> Añadir</a></div>';
                    html+='</div>';
                    html+='</div>';
                    html+='</div>';
                    html+=' </div>';
                    html+='</div>';
                    contcols=1;
                  }
                  contador++;
                });
                while(residuo>0 && residuo<5){
                    html+='<div class="col"></div>';
                    residuo++;
                }
                  if(!aumentahtml){
                    document.getElementById("productos").innerHTML="";
                    document.getElementById("productos").innerHTML=html;
                  }
                  else{
                    document.getElementById("productos").innerHTML+=html;
                    aumentahtml=false;
                  }
            });
          
    }
    function buscador(){
      document.getElementById('marca').innerText='Todas las marcas';
      marca="Todas";
      categoria="Todas";
      document.getElementById('categoria').value='Todas';
      console.log("buscará: ",document.getElementById("buscar").value);
      buscar=document.getElementById("buscar").value;
      document.getElementById("buscar").value="";
      porajax();
    }
    function mas(){
      limite+=15;
      aumentahtml=true;
      porajax();
    }
    function anadealcarrito(){

    }
    function vecarrito(){
      console.log("carrito: ",carrito);
      totaliza=0;
      html='<div class="list-group list-group-flush">';
      
      carrito.forEach((unprod,key) => {
        subtotal=unprod.precioventa * unprod.cuantos
        totaliza+=subtotal;
        html+='<div style="display:flex;"><div class="xitemcarrito" onclick="xitemcarrito('+key+')">x</div><a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action"> <span>'+unprod.descripcion+'</span></a>';
        html+=`<div class='cantcarrito'>
                  <div class="input-group input-spinner" style="flex-wrap:nowrap !important;">
                    <input type="button" value="-" class="button-minus  btn  btn-sm " data-field="quantity" onclick="disminuyeitem(this,`+key+`)">
                    <input type="number" step="1" max="10" value="`+unprod.cuantos+`" name="quantity" class="quantity-field form-control-sm form-input" style="width: 4.2em;" readonly>
                    <input type="button" value="+" class="button-plus btn btn-sm " data-field="quantity" onclick="aumentaitem(this,`+key+`)">
                  </div>
                  <div class="input-group input-spinner" style="flex-wrap:nowrap !important;">
                    
                    <span style="font-size:1.2em; width:100%;text-align:right;margin-right:5px" class="subtotal">Bs.`+subtotal+`</span>
                  </div>
               </div>
              </div>`;
       
      });
      html+=`<div style="text-align:right;font-weight:bold;color:limegreen;font-size:1.2em;"><span id="totaliza">Total Bs.`+totaliza+`</span></div>`;
      html+='</div>';
      document.getElementById("itemscarrito").innerHTML=html;

    }
    function xitemcarrito(key){
      carrito.splice(key,1);
      vecarrito();
    }
    function aumentaitem(objeto,key){
      lacant=objeto.parentElement.querySelector("input[type=number]");
      lacant.value++;
      carrito[key].cuantos=lacant.value;
      subtotal=carrito[key].precioventa * carrito[key].cuantos;
      objeto.parentElement.parentElement.querySelector("div:nth-child(2) span").innerText="Bs."+subtotal;
      totalizador();
    }
    function disminuyeitem(objeto,key){
      lacant=objeto.parentElement.querySelector("input[type=number]");
      if(lacant.value>1) {lacant.value--;}
      carrito[key].cuantos=lacant.value;
      subtotal=carrito[key].precioventa * carrito[key].cuantos;
      objeto.parentElement.parentElement.querySelector("div:nth-child(2) span").innerText="Bs."+subtotal;
      totalizador();
    }
    function totalizador(){
      totaliza=0;
      carrito.forEach(unprod => {
        totaliza+=unprod.precioventa * unprod.cuantos;
        document.getElementById("totaliza").innerText="Total Bs."+totaliza;
      });
    }
</script>