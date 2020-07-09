@extends('layouts.board')

@section('content2')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/datos">Datos</a></li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/propiedades">Propiedades</a></li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/propietarios">Propietarios</a></li>
                    <li class="breadcrumb-item" aria-current="page">Asignar propiedades</li>
                </ol>
            </nav>

            <comunidad-asignar :comunidad_id="'{{ $comunidad->id }}'"></comunidad-asignar>                 
        </div>
    </div>
</div>
@endsection

