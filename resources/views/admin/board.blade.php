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
                    <li><a href="/comunidad/{{ $comunidad->id }}/asignar">Asignación propiedades y propietarios</a></li>
                </ul>                  
            </div>
        </div>
        <div class="card col-lg-5 col-md-8 col-sm-8 m-2">
            <div class="card-header">
                <span>Contabilidad</span>
            </div>
            <div class="card-body">
                <ul>
                    <li>Proveedores</li>
                    <li>Bancos y cajas</li>
                    <li>Gastos</li>
                    <li>Ingresos</li>
                </ul>                    
            </div>
        </div>
    </div>
</div>
@endsection

