@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => 'Access is denied'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Доступ запрещен</h4>
                        </div>
                        <div class="card-body">
                            Доступ запрещен
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'box'])
    </div>
@endsection

