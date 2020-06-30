@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex flex-row justify-content-between">
                    <div class="align-self-center">
                        <h4 class="mb-0">{{ $comunidad_nombre }}</h4>
                    </div>
                    @if(session('c'.$comunidad_id) == 'admin')
                    <div>
                        <form method='POST' action="/comunidad/admin">
                            @csrf
                            <input type="hidden" name='cid' value="{{$comunidad_id}}">
                            <input type="submit" value="Administrar">
                        </form>
                    </div>
                    @endif
                </div>

                <div class="card-body" id="accordion">
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
                                <listar-prop-user :com_id="'{{$comunidad_id}}'"></listar-prop-user>                       
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
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Collapsible Group Item #3
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

