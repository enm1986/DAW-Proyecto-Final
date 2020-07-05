@extends('layouts.app')

@section('content')
<div class="container">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="navbar-nav btn-group flex-row" role="group" >
            <a class="btn btn-light" href="/comunidad/{{ $comunidad->id }}">Portada</a>
        </div>
        @if($acceso == 'admin')
        <a class="btn btn-outline-light" href="/comunidad/{{ $comunidad->id }}/admin" role="button">Administrar</a>
        @endif
    </nav>
    <div class="container p-0">
        @yield('content2')
    </div>
</div>
@endsection

