@extends('layouts.board')

@section('content2')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Proveedores</li>
                </ol>
            </nav>

            <comunidad-proveedores :comunidad_id="'{{ $comunidad->id }}'"></comunidad-proveedores>                 
        </div>
    </div>
</div>
@endsection

