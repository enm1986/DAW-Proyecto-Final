@extends('layouts.board')

@section('content2')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Actual</li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/cuentas">Bancos y cuentas</a></li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/gastos">Gastos</a></li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/ingresos">Ingresos</a></li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/cuotas">Cuotas</a></li>
                </ol>
            </nav>

            <comunidad-proveedores :comunidad_id="'{{ $comunidad->id }}'"></comunidad-proveedores>                 
        </div>
    </div>
</div>
@endsection

