@extends('layouts.board')

@section('content2')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/datos">Datos</a></li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/propiedades">Propiedades</a></li>
                    <li class="breadcrumb-item" aria-current="page">Propietarios</li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/asignar">Asignar propiedades</a></li>
                </ol>
            </nav>

            <comunidad-propietarios :comunidad_id="'{{ $comunidad->id }}'"></comunidad-propietarios>                 
        </div>
    </div>
</div>
@endsection

