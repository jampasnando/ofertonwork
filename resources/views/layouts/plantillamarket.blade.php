<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta property="og:title" content="{{$unprod->descripcion}}" />
    <meta property="og:description" content="{{$unprod->marca}}" />
    <meta property="og:image" content="{{url('/images/'.$unprod->imagenes)}}" /> --}}
    <meta property="og:site_name" content="Ferreteria Oferton">
    <meta property="og:url" content="https://ferreteriaoferton.com">
    <meta property="og:title" content="{{$unprod->descripcion}}">
    <meta property="og:type" content="website">
    <meta property="og:description" content="{{$unprod->marca}}">
    {{-- <meta property="og:image" content="{{url('/images/'.$unprod->imagenes)}}">
    <meta property="og:image:secure_url" content="{{url('/images/'.$unprod->imagenes)}}"> --}}
    <meta property="og:description" content="Herramientas y mas">
    <meta property="og:image" content="{{url('/imagenes/icon.png')}}">
    <meta property="og:image:secure_url" content="{{url('/imagenes/icon.png')}}">
    {{-- <meta property="fb:app_id" content="932617421869604"> --}}
    @yield('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel='stylesheet' id='dokan-fontawesome-css'  href='https://themes.getbootstrap.com/wp-content/plugins/dokan-lite/assets/vendors/font-awesome/font-awesome.min.css?ver=2.9.27' type='text/css' media='all' />
    <link rel='stylesheet' id='dokan-theme-skin-css'  href='https://themes.getbootstrap.com/wp-content/themes/dokan/assets/css/skins/purple.css' type='text/css' media='all' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    
    <title>FERRETERIA OFERTON</title>
    
  </head>
  <body>
    <div class="header" style="width:100%;">
      <div >
        <header class=" mb-3" style="position: fixed;width:100%;z-index:999;">
          <div style="display: flex;background:white;" class="px-2 py-3">
            <img src="{{url('/imagenes/logo.svg')}}" alt="" style="height: 2em;">
            <div class="input-group">
              {{-- <select class="form-select" onchange="buscar='';categoria=this.value;porajax();" id="categoria">
                <option selected="selected" value='Todas'>Todas las Categorias</option>
                @foreach ($categorias as $unacat)
                  <option value="{{$unacat->categoria}}">{{$unacat->categoria}}</option>
                @endforeach
                 
                 
              </select> --}}
              <input type="text" aria-label="Last name" class="form-control w-45" placeholder="Buscar un producto" onchange="buscador()" id="buscar">
              <button class="input-group-text bg-transparent" type="submit" onclick="buscador();">
                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                 </svg>
              </button>
           </div>
           <div class="col-xxl-3 col-lg-4 d-flex align-items-center px-2 ">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-gray-400 text-muted " data-bs-toggle="modal" data-bs-target="#modalCiudades" style="background:lightgoldenrodyellow;border: 1px solid gold;font-weight: bold;" id="btnmodalciudades">
              <i data-feather="map-pin" style="height: 1em;"></i>&nbsp;<span id="sucursal">Todas las Sucursales</span>
            </button>
            <div class="list-inline ms-auto d-lg-block d-none">
               <div class="list-inline-item">
                  <a href="../pages/shop-wishlist.html" class="text-muted position-relative">
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                        </path>
                     </svg>
                     <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                     5
                     <span class="visually-hidden">unread messages</span>
                     </span>
                  </a>
               </div>
               <div class="list-inline-item">
                  <a href="#!" class="text-muted" data-bs-toggle="modal" data-bs-target="#userModal">
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                     </svg>
                  </a>
               </div>
               <div class="list-inline-item">
                  <a class="text-muted position-relative " data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" href="#offcanvasExample" role="button" aria-controls="offcanvasRight">
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                     </svg>
                     <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                     1
                     <span class="visually-hidden">unread messages</span>
                     </span>
                  </a>
               </div>
            </div>
         </div>
          </div>


        <nav class="navbar navbar-expand-lg  navbar-dark bg-warning d-none d-lg-block navbar-default " style="display: flex !important;">
          <div class="container-fluid px-0 px-md-3">
            <div class="dropdown me-3 d-none d-lg-block">
                <button class="btn btn-light px-6 " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="me-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                      </svg>
                  </span>
                  <span id="marca">Todas las marcas</span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="max-height: 50vh;overflow:auto;">
                  <li><a class="dropdown-item" href="#" style="padding: 0 1em;border-bottom:1px solid lightgray;" onclick="marca='Todas';buscar='';document.getElementById('marca').innerText='Todas las marcas';porajax();">Todas las marcas</a></li>
                  @foreach ($marcas as $unamarca)
                    <li><a class="dropdown-item" href="#" style="padding: 0 1em;border-bottom:1px solid lightgray;" onclick="marca='{{$unamarca->marca}}';buscar='';document.getElementById('marca').innerText='{{$unamarca->marca}}';porajax();">{{$unamarca->marca}}</a></li>
                  @endforeach
                  
                  
                </ul>
            </div>
            <div class="me-auto p-4 p-lg-0">
                <div class="d-none d-lg-block">
                  <ul class="navbar-nav align-items-center">
                      <li class="nav-item dropdown" >
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:white;">
                        Inicio
                        </a>
                        <li>
                          <a class="nav-link" href="#" style="color:white;" data-bs-toggle="modal" data-bs-target="#modalcarrusel">
                            <span style="color:red;">&#9829;</span> OFERTAS <span style="color:red;">&#9829;</span>
                            </a>
                        </li>
                        {{-- <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../index.html">Opcion 1</a></li>
                            <li><a class="dropdown-item" href="../pages/index-2.html">Opcion 2</a></li>
                            <li><a class="dropdown-item" href="../pages/index-3.html">Opcion 3</a></li>
                            <li><a class="dropdown-item" href="../pages/index-4.html">Opcion 4 <span class="badge bg-light-info text-dark-info ms-1">New</span></a></li>
                        </ul> --}}
                      </li>
                      {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:white;">
                        Comprar
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../pages/shop-grid.html">Producto x</a></li>
                            <li><a class="dropdown-item" href="../pages/shop-grid-3-column.html">Producto x</a></li>
                            <li><a class="dropdown-item" href="../pages/shop-list.html">Producto x</a></li>
                            <li><a class="dropdown-item" href="../pages/shop-filter.html">Producto x</a></li>
                            <li><a class="dropdown-item" href="../pages/shop-fullwidth.html">Producto x</a></li>
                            <li><a class="dropdown-item" href="../pages/shop-single.html">Producto x</a></li>
                            <li><a class="dropdown-item" href="../pages/shop-single-2.html">Producto x></a></li>
                            <li><a class="dropdown-item" href="../pages/shop-wishlist.html">Producto x</a></li>
                            <li><a class="dropdown-item" href="../pages/shop-cart.html">Producto x</a></li>
                            <li><a class="dropdown-item" href="../pages/shop-checkout.html">Producto x</a></li>
                        </ul>
                      </li> --}}
                      {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:white;">
                        Sucursales
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../pages/store-list.html">Cochabamba</a></li>
                            <li><a class="dropdown-item" href="../pages/store-grid.html">Santa Cruz</a></li>
                            <li><a class="dropdown-item" href="../pages/store-single.html">Oruro</a></li>
                            <li><a class="dropdown-item" href="../pages/store-grid.html">La Paz</a></li>
                            <li><a class="dropdown-item" href="../pages/store-single.html">El Alto</a></li>
                        </ul>
                      </li> --}}
                      {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:white;">
                        Ofertas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../pages/blog.html">De Hoy</a></li>
                            <li><a class="dropdown-item" href="../pages/blog-single.html">De la semana</a></li>
                            <li><a class="dropdown-item" href="../pages/blog-category.html">Del mes</a></li>
                        </ul>
                      </li>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:white;">
                        Servicios
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../pages/signin.html">Soporte</a></li>
                            <li><a class="dropdown-item" href="../pages/signup.html">Seguimiento</a></li>
                            <li><a class="dropdown-item" href="../pages/forgot-password.html">Delivery</a></li>
                            
                        </ul>
                      </li>
                      <li class="nav-item ">
                        <a class="nav-link" href="../dashboard/index.html" style="color:white;">
                        Archivos
                        </a>
                      </li>
                      <li class="nav-item dropdown dropdown-flyout">
                        <a class="nav-link" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">
                        Cuenta
                        </a>
                      </li> --}}
                  </ul>
                </div>
            </div>
          </div>
          <div class="social" style="display:flex;margin-right: 1em;position: relative;">
            <div id="divcarrito" data-bs-toggle="modal" data-bs-target="#modalCarrito" onclick="vecarrito()" style="cursor: pointer;display:none;" >
              <div class="carrito carritobrilla">
                <img src="{{url('/imagenes/carrito.svg')}}" alt="" style="height: 2em;">
              </div>
              <div class="nroitemscarrito" id="nroitemscarrito"></div>
            </div>
            <a href="https://www.facebook.com/ElOfertonFerreteriaOnline" target="_blank"><img src="{{url('/imagenes/logoface.png')}}" alt="" style="width: 2.4em;"></a>&nbsp;
            <a href="https://api.whatsapp.com/send?phone=59177939732" target="_blank"><img src="{{url('/imagenes/logowhats.png')}}" alt="" style="width: 2.4em;"></a>
          </div>
          <div data-bs-toggle="modal" data-bs-target="#modalComprobarcompra" style="cursor: pointer;display:none;" id="btncomprobarcompra">
      </nav>
      </header>
      </div>
    </div>
    <link rel="stylesheet" href="{{asset('css/cssmarket.css').'?'.time()}}">
    <div class="container-fluid">
      <div class="ancho">
        <div class="espacio"></div>
        <div class="espacio"></div>
        <div class="espacio"></div>
        <div class="espacio"></div>
        <div class="espacio"></div>
        <div class="espacio"></div>
        <div class="espacio"></div>
        <div class="espacio"></div>
        <div class="espacio"></div>
        @yield("contenido")
      </div>
    </div>
    <div class="footer" style="background:lightgrey;width:100%;height:5em;">
      {{-- @yield("pie"); --}}
      <div >
        {{-- <h1>ESTE ES EL PIE</h1> --}}
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace();
    </script>
     @yield('js')
  </body>
</html>