<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-success">
                    <h4 class="card-title ">Заявки + Приход/Расход</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class=" text-primary">
                            <th>ID платежа</th>
                            <th>ID заявки</th>
                            <th>Приход/Расход</th>
                            <th>Сумма</th>
                            <th>Дата создания</th>
                            <th>Дата изменения</th>
                            <th>Кто добавил</th>
                            <th>Кто изменил</th>
                            </thead>
                            <tbody>
                            @isset($listMoneyMovement)
                                @foreach($listMoneyMovement as $moneyMovement)
                                    <tr>
                                        <td>{{$moneyMovement->id}}</td>
                                        <td>{{$moneyMovement->bid_id}}</td>
                                        <td>{{$moneyMovement->inc_exp}}</td>
                                        <td>{{$moneyMovement->amount}}</td>
                                        <td>{{$moneyMovement->created_at}}</td>
                                        <td>{{$moneyMovement->updated_at}}</td>
                                        <td>{{$moneyMovement->created_full_name}}</td>
                                        <td>{{$moneyMovement->updated_full_name}}</td>
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
