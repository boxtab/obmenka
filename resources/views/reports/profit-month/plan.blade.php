<div class="card">
    <div class="card-header card-header-success">
        <h4 class="card-title">План</h4>
        <p class="card-category">Отчет</p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead class="text-primary">
                    <th>Группы источников дохода</th>
                    <th>План</th>
                    <th>Факт</th>
                    <th>Факт, %</th>
                    <th>Прогноз, %</th>
                    <th>До плана</th>
                    <th>Динамика</th>
                </thead>
                <tbody>
                    @isset( $listProfitPlan )
                        @foreach( $listProfitPlan as $profitPlan )
                            <tr>
                                <td>{{ $profitPlan['date_month'] ?? '' }}</td>
                                <td>{{ $profitPlan['client'] ?? '' }}</td>
                                <td>{{ $profitPlan['average_check'] ?? '' }}</td>
                                <td>{{ $profitPlan['turnover'] ?? '' }}</td>
                                <td>{{ $profitPlan['profit'] ?? '' }}</td>
                                <td>{{ $profitPlan['percent_profit'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
</div>
