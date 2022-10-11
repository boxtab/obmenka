@extends('layouts.app', ['activePage' => 'direction-balance', 'titlePage' => 'Остатки по направлениям'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Остатки по направлениям</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>ID</th>
                                        <th>Направление</th>
                                        <th>Остаток</th>
                                    </thead>
                                    <tbody>
                                        @isset($listDirection)
                                            @foreach($listDirection as $direction)
                                                <tr>
                                                    <td>{{$direction['id']}}</td>
                                                    <td>{{$direction['direction_descr'] ?? ''}}</td>
                                                    <td>{{$direction['direction_balance'] ?? ''}}</td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Остатки по валютам</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                    <th>Валюта</th>
                                    <th>Остаток</th>
                                    </thead>
                                    <tbody>
                                    @isset($listCurrency)
                                        @foreach($listCurrency as $currency)
                                            <tr>
                                                <td>{{$currency['currency_descr'] ?? ''}}</td>
                                                <td>{{$currency['balance'] ?? ''}}</td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


