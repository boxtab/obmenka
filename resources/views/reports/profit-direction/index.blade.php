@extends('layouts.app', ['activePage' => 'reports.profit-direction', 'titlePage' => 'Доход по направлениям'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Доходы по направлениям</h4>
                            <p class="card-category">Отчет</p>
                        </div>
                        <div class="card-body">
                            @include('reports.profit-direction.panel')
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>Приход</th>
                                        <th>Расход</th>
                                        <th>Количество операций</th>
                                        <th>Объем</th>
                                        <th>Сумма дохода</th>
                                    </thead>
                                    <tbody>
                                        @isset( $listProfitDirection )
                                            @foreach( $listProfitDirection as $profitDirection )
                                                <tr>
                                                    <td>{{ $profitDirection['income_name'] ?? '' }}</td>
                                                    <td>{{ $profitDirection['expense_name'] ?? '' }}</td>
                                                    <td class="calc">{{ $profitDirection['count_operation'] ?? '' }}</td>
                                                    <td class="calc">{{ $profitDirection['volume'] ?? '' }}</td>
                                                    <td class="calc">{{ $profitDirection['profit_amount'] ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                    @isset( $totalProfitDirection )
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="font-weight:bold">{{ $totalProfitDirection['count_operation'] ?? '' }}</td>
                                            <td style="font-weight:bold">{{ $totalProfitDirection['volume'] ?? '' }}</td>
                                            <td style="font-weight:bold">{{ $totalProfitDirection['profit_amount'] ?? '' }}</td>
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
