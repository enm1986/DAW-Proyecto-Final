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
                    Estado de las cuentas
                </button>
            </h5>
        </div>
        <div id="listaBalance" class="collapse" aria-labelledby="balance" data-parent="#accordion">
            <div class="card-body">
                <ul>
                    <li><a href="#" data-toggle="modal" data-target="#fondos">Fondos</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#cuentas">Cuentas bancarias</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#miBalance">Mi balance</a></li>
                </ul>                    
            </div>
        </div>
    </div>
    <!-- Modal Fondos-->
    <div class="modal fade" id="fondos" tabindex="-1" role="dialog" aria-labelledby="modalFondos" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFondos">Estado de los fondos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <listar-fondos :comunidad_id="'{{ $comunidad->id }}'"></listar-fondos> 
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Cuentas-->
    <div class="modal fade" id="cuentas" tabindex="-1" role="dialog" aria-labelledby="modalCuentas" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCuentas">Cuentas bancarias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <listar-cuentas :comunidad_id="'{{ $comunidad->id }}'"></listar-cuentas>   
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Balance-->
    <div class="modal fade" id="miBalance" tabindex="-1" role="dialog" aria-labelledby="modalBalance" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBalance">Mi Balance de cuentas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <listar-cuotas :comunidad_id="'{{ $comunidad->id }}'"></listar-cuotas> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

