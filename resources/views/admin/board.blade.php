@extends('layouts.board')

@section('content2')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-lg-5 col-md-8 col-sm-10 m-2">
            <div class="card-header">
                <span>Configuración general</span>
            </div>
            <div class="card-body">
                <ul>
                    <li><a href="/comunidad/{{ $comunidad->id }}/datos">Datos de la comunidad</a></li>
                    <li><a href="/comunidad/{{ $comunidad->id }}/propiedades">Propiedades</a></li>
                    <li><a href="/comunidad/{{ $comunidad->id }}/propietarios">Propietarios</a></li>
                    <li><a href="/comunidad/{{ $comunidad->id }}/asignar">Asignación de propiedades</a></li>
                </ul>
                <hr>
                <ul>
                    <li><a href="/comunidad/{{ $comunidad->id }}/proveedores">Proveedores</a></li>
                </ul>
            </div>
        </div>
        <div class="card col-lg-5 col-md-8 col-sm-10 m-2">
            <div class="card-header">
                <span>Contabilidad</span>
            </div>
            <div class="card-body">
                <ul>
                    <li><a href="/comunidad/{{ $comunidad->id }}/fondos">Fondos</a></li>
                    <li><a href="/comunidad/{{ $comunidad->id }}/cuentas">Bancos y cajas</a></li>
                    <li><a href="/comunidad/{{ $comunidad->id }}/gastos">Gastos</a></li>
                    <li><a href="/comunidad/{{ $comunidad->id }}/cuotas">Cuotas</a></li>
                    <li><a href="/comunidad/{{ $comunidad->id }}/ingresos">Ingresos</a></li>
                </ul>                    
            </div>
        </div>
    </div>
</div>
@endsection

