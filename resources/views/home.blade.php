@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                @include('layouts.sidebar')
            </div>

            @if (isset($id_menu))
                @switch($id_menu)
                    @case(1)
                        <div class="col-md-6">
                            @include('recibos.nuevorecibo')
                        </div>
                        <div class="col-md-2">&nbsp;</div>
                    @break

                    @case(2)
                        <div class="col-md-6">
                            @include('clientes.cargaclientes')
                        </div>
                        <div class="col-md-2">&nbsp;</div>
                    @break

                    @case(3)
                        <div class="col-md-8">
                            @include('recibos.detallerecibo')
                        </div>
                    @break

                    @case(4)
                        <div class="col-md-8">
                            @include('recibos.listado')
                        </div>
                    @break

                    @default
                @endswitch
            @endif
        </div>

    </div>
    
@endsection
