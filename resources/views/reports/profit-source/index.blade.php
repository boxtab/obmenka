@extends('layouts.app', ['activePage' => 'reports.profit-source', 'titlePage' => 'Доходы по источнику'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Доходы по источнику</h4>
                            <p class="card-category">Отчет</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                @include('reports.profit-source.panel')
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>Направление</th>
                                        <th title="По заявкам">Количество операций</th>
                                        <th title="Сумма дохода">Объем</th>
                                        <th title="Разница">Доход</th>
                                        <th>Доход по 3 код ДДС</th>
                                        <th title="Доход + 3 код">Общий доход</th>
                                    </thead>
                                    <tbody>
                                        @isset( $listProfitSource )
                                            @foreach( $listProfitSource as $profitSource )
                                                <tr>
                                                    <td>{{ $profitSource['top_destinations_descr'] ?? '' }}</td>
                                                    <td>{{ $profitSource['count_operation'] ?? '' }}</td>
                                                    <td>{{ $profitSource['volume'] ?? '' }}</td>
                                                    <td>{{ $profitSource['profit_amount'] ?? '' }}</td>
                                                    <td>{{ $profitSource['profit_amount_dds'] ?? '' }}</td>
                                                    <td>{{ $profitSource['profit_amount_common'] ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                    @isset( $totalProfitSource )
                                        <tfoot>
                                        <tr>
                                            <td></td>
                                            <td style="font-weight:bold">{{ $totalProfitSource['count_operation'] ?? '' }}</td>
                                            <td style="font-weight:bold">{{ $totalProfitSource['volume'] ?? '' }}</td>
                                            <td style="font-weight:bold">{{ $totalProfitSource['profit_amount'] ?? '' }}</td>
                                            <td style="font-weight:bold">{{ $totalProfitSource['profit_amount_dds'] ?? '' }}</td>
                                            <td style="font-weight:bold">{{ $totalProfitSource['profit_amount_common'] ?? '' }}</td>
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
