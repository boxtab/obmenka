@extends('layouts.app', ['activePage' => 'direction', 'titlePage' => 'Направление: Добавление/Редактирование'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('direction.store') }}" autocomplete="off"
                          id="form-exchange-direction" class="form-horizontal">
                        @csrf
                        <div class="card ">
                            <div class="card-header card-header-success">
                                <h4 class="card-title">Направление</h4>
                                <p class="card-category">Добавление/Редактирование</p>
                            </div>

                            <div class="card-body ">
                                @if(isset($direction))
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">ID</label>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <input class="form-control" name="id" id="input-id"
                                                       type="text" readonly value="{{ $direction->id ?? '' }}"/>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="input-group form-group required">
                                        <label class="col-sm-2 col-form-label input-group-addon"
                                               for="select-left_payment_system">Платежная система*</label>
                                        <div class="col-sm-2">
                                            <select id="select-left_payment_system" name="payment_system_id"
                                                    required class="selectpicker"
                                                    data-style="btn btn-primary btn-round">
                                                <option disabled selected>Выберите из списка</option>
                                                @foreach($listPaymentSystem as $paymentSystem)
                                                    <option value="{{$paymentSystem->id}}"
                                                            @if(old('payment_system_id') == $paymentSystem->id)
                                                            selected
                                                            @elseif(isset($direction) && $direction->payment_system_id === $paymentSystem->id )
                                                            selected
                                                        @endif>
                                                        {{$paymentSystem->descr}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-sm-1 col-form-label input-group-addon"
                                               for="select-left_currency">Код валюты*</label>
                                        <div class="col-sm-3">
                                            <select id="select-left_currency" name="currency_id"
                                                    required class="selectpicker"
                                                    data-style="btn btn-primary btn-round">
                                                <option disabled selected>Выберите из списка</option>
                                                @foreach($listCurrency as $currency)
                                                    <option value="{{$currency->id}}"
                                                            @if(old('currency_id') == $currency->id)
                                                            selected
                                                            @elseif( isset($direction) && $direction->currency_id === $currency->id )
                                                            selected
                                                        @endif>
                                                        {{$currency->descr}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @if(isset($Direction))
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Дата создания</label>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <input class="form-control" name="created_at"
                                                       id="input-created_at" type="text" disabled
                                                       value="{{ $direction->created_at ?? '' }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Дата редактирования</label>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <input class="form-control" name="updated_at"
                                                       id="input-updated_at" type="text" disabled
                                                       value="{{ $direction->updated_at ?? '' }}"/>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer ml-auto mr-auto">
                                <div class="col-lg-6 text-left">
                                    <button type="submit" form="form-exchange-direction" class="btn btn-primary">
                                        Сохранить
                                    </button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <a href="{{ route('direction.index') }}" class="btn btn-block" role="button">
                                        Назад
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
