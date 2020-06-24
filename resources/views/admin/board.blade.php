@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $comunidad_nombre }} - Administrador</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <listar-prop-user :com_id="'{{$comunidad_id}}'"></listar-prop-user>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
