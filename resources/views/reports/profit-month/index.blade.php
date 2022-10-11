@extends('layouts.app', ['activePage' => 'reports.profit-month', 'titlePage' => 'Доходы за месяц'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            @include('reports.profit-month.panel')
            <div class="row">
                <div class="col-md-12">
                    @include('reports.profit-month.month')
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @include('reports.profit-month.plan')
                </div>
            </div>
        </div>
    </div>
@endsection
