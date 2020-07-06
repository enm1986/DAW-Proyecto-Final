@extends('layouts.app')

@section('content')
<div class="container">
    <nav class="navbar navbar-dark bg-secondary mb-4 p-2 shadow">
        <div class="navbar-nav flex-row">
            <a class="btn btn-light m-1 " href="/home">Mis comunidades</a>
            <a class="btn btn-light m-1" href="/comunidad/{{ $comunidad->id }}">Portada</a>
        </div>
        @if($acceso == 'admin')
        <a class="btn btn-outline-light m-1" href="/comunidad/{{ $comunidad->id }}/admin" role="button">Administrar</a>
        @endif
    </nav>
    <div class="container p-0">
        @yield('content2')
    </div>
</div>
@endsection

