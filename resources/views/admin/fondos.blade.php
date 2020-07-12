@extends('layouts.board')

@section('content2')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Fondos</li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/cuentas">Bancos y cuentas</a></li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/gastos">Gastos</a></li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/cuotas">Cuotas</a></li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/ingresos">Ingresos</a></li>
                </ol>
            </nav>

            <contabilidad-fondos :comunidad_id="'{{ $comunidad->id }}'"></contabilidad-fondos>                 
        </div>
    </div>
</div>
@endsection
