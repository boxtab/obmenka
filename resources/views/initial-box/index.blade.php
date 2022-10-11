@extends('layouts.app', ['activePage' => 'initial-box', 'titlePage' => 'Начальные остатки счетов'])

@push('js')
    <script src="{{ asset('js/initial-box/list.js') }}?v=@version" defer></script>
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Начальные остатки счетов</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="table-initial-box">
                                    <thead class="text-primary">
                                        <th>ID</th>
                                        <th>Карта/Кошелек</th>
                                        <th>Счет</th>
                                        <th>Остаток</th>
                                    </thead>
                                    <tbody>
                                        @isset( $listBalanceBox )
                                            @foreach( $listBalanceBox as $balanceBox )
                                                <tr>
                                                    <td>{{ $balanceBox['id'] ?? '' }}</td>
                                                    <td>{{ $balanceBox['type_box_descr'] ?? '' }}</td>
                                                    <td>{{ $balanceBox['unique_name'] ?? '' }}</td>
                                                    <td><input type="number" data-id="{{$balanceBox['id']}}" class="balance" value="{{ $balanceBox['balance'] ?? ''}}"></td>
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
