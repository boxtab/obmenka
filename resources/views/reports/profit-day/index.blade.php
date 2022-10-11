@extends('layouts.app', ['activePage' => 'reports.profit-day', 'titlePage' => 'Доход по каждой операции'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Доход по каждой операции</h4>
                            <p class="card-category">Отчет</p>
                        </div>
                        <div class="card-body">
                            @include('reports.profit-day.panel')
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>ID заявки</th>
                                        <th title="Дата последнего изменения заявки">Дата заявки</th>
                                        <th>Направления обмена</th>
                                        <th>Источник дохода</th>
                                        <th title="Сумма прихода по заявке">Приход</th>
                                        <th title="Сумма расхода по заявке">Расход</th>
                                        <th title="Приход - Расход">Разница</th>
                                    </thead>
                                    <tbody>
                                        @isset( $listProfitDay )
                                            @foreach( $listProfitDay as $profitDay )
                                                <tr>
                                                    <td>{{ $profitDay['id'] ?? '' }}</td>
                                                    <td>{{ $profitDay['date_bid'] ?? '' }}</td>
                                                    <td>{{ $profitDay['exchange_direction_descr'] ?? '' }}</td>
                                                    <td>{{ $profitDay['top_destinations_descr'] ?? '' }}</td>
                                                    <td class="calc">{{ $profitDay['income'] ?? '' }}</td>
                                                    <td class="calc">{{ $profitDay['expense'] ?? '' }}</td>
                                                    <td class="calc">{{ $profitDay['difference'] ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                    @isset( $totalProfitDay )
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="font-weight:bold">{{ $totalProfitDay['income'] ?? '' }}</td>
                                                <td style="font-weight:bold">{{ $totalProfitDay['expense'] ?? '' }}</td>
                                                <td style="font-weight:bold">{{ $totalProfitDay['difference'] ?? '' }}</td>
                                            </tr>
                                        </tfoot>
                                    @endisset
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('summary-line')
    @include('summary-line')
@endsection
