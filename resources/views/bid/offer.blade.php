<div class="col-sm-6">
    <div class="card">
        <div class="card-header card-header-success">
            <h4 class="card-title">
                Приход (<span id="offer_sum_income">{{$offerGetSum ?? 0}}</span>)
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-horizontal">
                        <select id="select_box_id_income" name="left_box_id" class="selectpicker"
                                data-style="btn btn-primary btn-round">
                            <option value="0" disabled selected>Счет*</option>
                            @isset($listBoxGet)
                                @foreach($listBoxGet as $boxGet)
                                    <option value="{{$boxGet->id}}">{{$boxGet->getFormatName()}}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-horizontal">
                        <input class="form-control" name="left_amount" id="input_amount_income"
                               type="number" placeholder="Сумма*" min="0" step="0.000000000001" value=""/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="col-lg-6 text-left">
                        <button class="btn btn-primary offer-add" data-type="income">Добавить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class=" text-primary">
                    <th>ID</th>
                    <th>Счет</th>
                    <th>Сумма</th>
                    <th>Дата редактирования</th>
                    <th class="icon"></th>
                    <th class="icon"></th>
                    </thead>
                    <tbody id="tbody_offer_income">
                    @isset($listOfferGet)
                        @foreach($listOfferGet as $offerGet)
                            <tr>
                                <td>{{ $offerGet->id }}</td>
                                <td>{{ $offerGet->box->getFormatName() }}</td>
                                <td class="calc">{{ $offerGet->amount }}</td>
                                <td>
{{--                                    <form action="{{ route('offer.update') }}" method="POST" id="form-offer-update-{{$offerGet->id}}">--}}
{{--                                        @csrf--}}
                                        <input type="hidden" name="offer_id" value="{{$offerGet->id}}">
                                        <input class="form-control" type="text" readonly name="updated_at" value="{{ $offerGet->updated_at->format('Y-m-d H:i') }}">
{{--                                        <input class="form-control" type="datetime-local" name="updated_at" value="{{ $offerGet->updated_at->format('Y-m-d\TH:i') }}">--}}
{{--                                    </form>--}}
                                </td>
{{--                                <td>--}}
{{--                                    <button type="submit" form="form-offer-update-{{$offerGet->id}}" class="btn btn-danger btn-link btn-sm">--}}
{{--                                        <i class="material-icons">arrow_circle_down</i>--}}
{{--                                    </button>--}}
{{--                                </td>--}}
                                <td>
                                    <button type="button" class="btn btn-danger btn-link btn-sm delete-confirm"
                                            data-id="{{$offerGet->id}}" data-toggle="modal" data-target="#deleteModal">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="card">
        <div class="card-header card-header-success">
            <h4 class="card-title">
                Расход (<span id="offer_sum_expense">{{$offerGiveSum ?? 0}}</span>)
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-horizontal">
                        <select id="select_box_id_expense" name="right_box_id" class="selectpicker"
                                data-style="btn btn-primary btn-round">
                            <option value="0" disabled selected>Счет*</option>
                            @isset($listBoxGive)
                                @foreach($listBoxGive as $boxGive)
                                    <option value="{{$boxGive->id}}">{{$boxGive->getFormatName()}}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-horizontal">
                        <input class="form-control" name="right_amount" id="input_amount_expense"
                               type="number" placeholder="Сумма*" min="0" step="0.000000000001" value=""/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="col-lg-6 text-left">
                        <button class="btn btn-primary offer-add" data-type="expense">Добавить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class=" text-primary">
                    <th>ID</th>
                    <th>Счет</th>
                    <th>Сумма</th>
                    <th>Дата редактирования</th>
                    <th class="icon"></th>
                    </thead>
                    <tbody id="tbody_offer_expense">
                    @isset($listOfferGive)
                        @foreach($listOfferGive as $offerGive)
                            <tr>
                                <td>{{ $offerGive->id }}</td>
                                <td>{{ $offerGive->box->getFormatName() }}</td>
                                <td class="calc">{{ $offerGive->amount }}</td>
                                <td>
{{--                                    <form action="{{ route('offer.update') }}" method="POST" id="form-offer-update-{{$offerGive->id}}">--}}
{{--                                        @csrf--}}
                                        <input type="hidden" name="offer_id" value="{{$offerGive->id}}">
                                        <input class="form-control" readonly type="text" name="updated_at" value="{{ $offerGive->updated_at->format('Y-m-d H:i') }}">
{{--                                        <input class="form-control" type="datetime-local" name="updated_at" value="{{ $offerGive->updated_at->format('Y-m-d\TH:i') }}">--}}
{{--                                    </form>--}}
                                </td>
{{--                                <td>--}}
{{--                                    <button type="submit" form="form-offer-update-{{$offerGive->id}}" class="btn btn-danger btn-link btn-sm">--}}
{{--                                        <i class="material-icons">arrow_circle_down</i>--}}
{{--                                    </button>--}}
{{--                                </td>--}}
                                <td>
                                    <button type="button" class="btn btn-danger btn-link btn-sm delete-confirm"
                                            data-id="{{$offerGive->id}}" data-toggle="modal"
                                            data-target="#deleteModal">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
