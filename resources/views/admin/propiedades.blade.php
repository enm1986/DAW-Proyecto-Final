@extends('layouts.board')

@section('content2')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/datos">Datos</a></li>
                    <li class="breadcrumb-item" aria-current="page">Propiedades</li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/propietarios">Propietarios</a></li>
                    <li class="breadcrumb-item"><a href="/comunidad/{{ $comunidad->id }}/asignar">Asignar propiedades</a></li>
                </ol>
            </nav>

            <comunidad-propiedades :comunidad_id="'{{ $comunidad->id }}'"></comunidad-propiedades>                     
        </div>
    </div>
</div>
@endsection

