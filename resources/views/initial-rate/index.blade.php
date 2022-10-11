@extends('layouts.app', ['activePage' => 'initial-rate', 'titlePage' => 'Начальные остатки для средних курсов'])

@push('js')
    <script src="{{ asset('js/initial-rate/list.js') }}?v=@version" defer></script>
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Начальные остатки для средних курсов</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="table-initial-rate">
                                    <thead class="text-primary">
                                        <th>ID</th>
                                        <th>Валюта</th>
                                        <th>Остаток</th>
                                        <th>Курс к рублю</th>
                                        <th>Остаток в рубле</th>
                                    </thead>
                                    <tbody>
                                        @isset($listInitialRate)
                                            @foreach($listInitialRate as $initialRate)
                                                <tr>
                                                    <td>{{$initialRate['id'] ?? ''}}</td>
                                                    <td>{{$initialRate['descr'] ?? ''}}</td>
                                                    <td><input type="text" data-id="{{$initialRate['id']}}" class="currency-balance" value="{{ $initialRate['balance'] ?? '' }}"></td>
                                                    <td><input type="text" data-id="{{$initialRate['id']}}" class="currency-rate" value="{{ $initialRate['rate'] ?? ''}}"></td>
                                                    <td>{{ $initialRate['balance_ruble'] ?? '' }}</td>
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

