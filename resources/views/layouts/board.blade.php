@extends('layouts.app')

@section('content')
<div class="container">
    <nav class="navbar navbar-dark bg-secondary mb-4 p-2 shadow justify-content-center justify-content-sm-between">
        <div class="navbar-nav flex-row">
            <a class="btn btn-light m-1 " href="/home">Mis comunidades</a>
            <a class="btn btn-light m-1" href="/comunidad/{{ $comunidad->id }}">Portada</a>
        </div>
        <div class="d-flex flex-wrap-reverse align-items-center flex-sm-wrap">
            <span class="text-light text-uppercase font-weight-bold m-2">{{ $comunidad->nombre }} </span>
            @if($acceso == 'admin')
            <a class="btn btn-outline-light m-1" href="/comunidad/{{ $comunidad->id }}/admin" role="button">Administrar</a>
            @endif
        </div> 
    </nav>
    <div class="container p-0">
        @yield('content2')
    </div>
</div>
@endsection

