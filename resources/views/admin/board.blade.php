@extends('layouts.board')

@section('content2')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span>ADMIN</span>
                </div>

                <div class="card-body">
                    <listar-prop-user :com_id="'{{ $comunidad->id }}'"></listar-prop-user>                       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

