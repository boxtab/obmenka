<div class="card">
    <div class="card-header card-header-success">
        <h4 class="card-title">Доходы за месяц</h4>
        <p class="card-category">Отчет</p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead class="text-primary">
                    <th>Дата</th>
                    <th title="Количество заявок">Клиенты</th>
                    <th title="Обороты/Количество клиентов">Средний чек</th>
                    <th title="Сумма всех приходов в рубле + сумма всех расходов в рубле">Обороты, руб</th>
                    <th>Доход, руб</th>
                    <th>Процент доходности</th>
                </thead>
                <tbody>
                    @isset( $listProfitMonth )
                        @foreach( $listProfitMonth as $profitMonth )
                            <tr>
                                <td>{{ $profitMonth['date_month'] ?? '' }}</td>
                                <td>{{ $profitMonth['client'] ?? '' }}</td>
                                <td>{{ $profitMonth['average_check'] ?? '' }}</td>
                                <td>{{ $profitMonth['turnover'] ?? '' }}</td>
                                <td>{{ $profitMonth['profit'] ?? '' }}</td>
                                <td>{{ $profitMonth['percent_profit'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endisset
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Сумма:</td>
                        <td style="font-weight:bold">{{ $monthSum['client'] ?? '' }}</td>
                        <td style="font-weight:bold">{{ $monthSum['average_check'] ?? '' }}</td>
                        <td style="font-weight:bold">{{ $monthSum['turnover'] ?? '' }}</td>
                        <td style="font-weight:bold">{{ $monthSum['profit'] ?? '' }}</td>
                        <td style="font-weight:bold">{{ $monthSum['percent_profit'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Прогноз:</td>
                        <td style="font-weight:bold">{{ $monthForecast['client'] ?? '' }}</td>
                        <td style="font-weight:bold">{{ $monthForecast['average_check'] ?? '' }}</td>
                        <td style="font-weight:bold">{{ $monthForecast['turnover'] ?? '' }}</td>
                        <td style="font-weight:bold">{{ $monthForecast['profit'] ?? '' }}</td>
                        <td style="font-weight:bold">{{ $monthForecast['percent_profit'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Среднее:</td>
                        <td style="font-weight:bold">{{ $monthAverage['client'] ?? '' }}</td>
                        <td style="font-weight:bold">{{ $monthAverage['average_check'] ?? '' }}</td>
                        <td style="font-weight:bold">{{ $monthAverage['turnover'] ?? '' }}</td>
                        <td style="font-weight:bold">{{ $monthAverage['profit'] ?? '' }}</td>
                        <td style="font-weight:bold">{{ $monthAverage['percent_profit'] ?? '' }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
