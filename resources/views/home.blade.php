@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex flex-row justify-content-between">
                    <h4 class="align-self-center m-0">Mis comunidades</h4>
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#nuevaComunidad">
                        Nueva comunidad
                    </button>
                    <div class="modal fade" id="nuevaComunidad" tabindex="-1" role="dialog" aria-labelledby="nuevaComunidadLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="nuevaComunidadLabel">Nueva Comunidad</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <crear-comunidad></crear-comunidad>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <listar-comunidades></listar-comunidades>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
