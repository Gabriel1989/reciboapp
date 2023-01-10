
<div class="nav-side-menu">
    <div class="brand">{{ config('app.name', 'Laravel') }}</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">
            <li class="menuLi" data-href="{{ url('/home') }}">
                <a href="{{ url('/home') }}">
                    <i class="fa fa-dashboard fa-lg"></i> Home
                </a>
            </li>

            <li data-toggle="collapse" data-target="#logout" class="collapsed">
                <a href="#">
                    <i class="fa fa-user fa-lg"></i> {{ Auth::user()->name }} <span class="arrow"></span>
                </a>
            </li>
            <ul class="sub-menu collapse" id="logout">
                <li onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"><a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Cerrar Sesión') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form></li>
            </ul>

            <li data-toggle="collapse" data-target="#products" class="collapsed active">
                <a href="#"><i class="fa fa-file"></i> Recibos <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse @if(isset($id_menu)) @if($id_menu == 1 || $id_menu == 4) show @endif @endif" id="products">
                <li class="active menuLi" data-href="{{ route('nuevoRecibo') }}"><a href="{{ route('nuevoRecibo') }}">Generar nuevo recibo</a></li>
                <li class="active menuLi" data-href="{{ route('listadoRecibos') }}"><a href="{{ route('listadoRecibos') }}">Listado de recibos</a></li>
            </ul>

            <li data-toggle="collapse" data-target="#clientes" class="collapsed active">
                <a href="#"><i class="fa fa-file-excel-o"></i> Clientes <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse @if(isset($id_menu)) @if($id_menu == 2) show @endif @endif"  id="clientes">
                <li class="active menuLi" data-href="{{ route('cargaClientes') }}"><a href="{{ route('cargaClientes') }}">Cargar datos Clientes</a></li>
            </ul>

            

        </ul>
        <script>
            $(document).on("click",".menuLi",function(){
                window.location.href = $(this).data('href');
            })
        </script>
    </div>
</div>