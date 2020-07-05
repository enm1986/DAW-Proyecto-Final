@extends('layouts.board')

@section('content2')
<div class="col-lg-8 col-md-10 col-sm-12 m-auto" id="accordion">
        <div class="card">
            <div class="card-header" id="comunidad">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#datos" aria-expanded="true" aria-controls="datos">
                        Datos de la comunidad de propietarios
                    </button>
                </h5>
            </div>
            <div id="datos" class="collapse" aria-labelledby="comunidad" data-parent="#accordion">
                <div class="card-body">
                    <p>Nombre: {{ $comunidad->nombre }}</p>
                    <p>CIF: {{ $comunidad->cif }}</p>
                    <p>Dirección: {{ $comunidad->direccion }}</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="propiedades">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#listaPropiedades" aria-expanded="false" aria-controls="listaPropiedades">
                        Mis Propiedades
                    </button>
                </h5>
            </div>

            <div id="listaPropiedades" class="collapse" aria-labelledby="propiedades" data-parent="#accordion">
                <div class="card-body">
                    <listar-propiedades :com_id="'{{ $comunidad->id }}'"></listar-propiedades>                       
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="balance">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#listaBalance" aria-expanded="false" aria-controls="listaBalance">
                        Balance de cuentas
                    </button>
                </h5>
            </div>
            <div id="listaBalance" class="collapse" aria-labelledby="balance" data-parent="#accordion">
                <div class="card-body">
                    En proceso                        
                </div>
            </div>
        </div>
    </div>
@endsection

