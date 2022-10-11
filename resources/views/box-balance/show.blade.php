@extends('layouts.app', ['activePage' => 'box-balance', 'titlePage' => 'Остатки: Добавление/Редактирование'])

@push('js')
    <script src="{{ asset('js/box-balance/show-input-filter-number.js') }}?v=@version" defer></script>
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post"
                          action="{{ route('box-balance.store') }}"
                          autocomplete="off"
                          id="form-box-balance"
                          class="form-horizontal">
                        @csrf
                        <div class="card">
                            <div class="card-header card-header-success">
                                <h4 class="card-title">Остатки</h4>
                                <p class="card-category">Добавление/Редактирование</p>

                                <div class="card-actions ml-auto mr-auto">
                                    <a href="{{ route('box-balance.index') }}" class="btn" role="button">Назад</a>
                                    <button class="btn btn-dark"
                                            type="button"
                                            data-toggle="collapse"
                                            data-target="#additional_info"
                                            aria-expanded="false"
                                            aria-controls="additional_info">
                                        Доп. инфо
                                    </button>
                                    <button type="submit" form="form-box-balance" class="btn btn-primary">Сохранить</button>
                                </div>

                            </div>

                            <div class="card-body">
                                <div class="collapse" id="additional_info">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">ID</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group">
                                                        <input
                                                            class="form-control"
                                                            name="id"
                                                            id="input-id"
                                                            type="text"
                                                            readonly
                                                            value="@if(isset($boxBalance)) {{$boxBalance->id}} @else {{''}} @endif"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">Дата баланса*</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('balance_date') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('balance_date') ? ' is-invalid' : '' }}"
                                                            name="balance_date"
                                                            id="input-balance_date"
                                                            type="date"
                                                            value="{{ ! empty($boxBalance) ? date('Y-m-d', strtotime($boxBalance->balance_date)) : null }}"
                                                        />
                                                        @if ($errors->has('balance_date'))
                                                            <span id="name-error" class="error text-danger" for="input-balance_date">{{ $errors->first('balance_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group form-group required">
                                                    <label
                                                        class="col-sm-2 col-form-label input-group-addon"
                                                        for="select-box_id"
                                                    >Счет*</label>
                                                    <div class="col-sm-2">
                                                        <select id="select-box_id"
                                                                name="box_id"
                                                                required
                                                                class="selectpicker"
                                                                data-style="btn btn-primary btn-round">
                                                            <option disabled selected>Выберите из списка</option>
                                                            @isset($listBox)
                                                                @foreach($listBox as $box)
                                                                    <option value="{{$box->id}}"
                                                                            @if(old('box_id') == $box->id)
                                                                                selected
                                                                            @elseif(isset($boxBalance) && $boxBalance->box_id === $box->id)
                                                                                selected
                                                                            @endif
                                                                    >{{$box->unique_name}}</option>
                                                                @endforeach
                                                            @endisset
                                                        </select>
                                                        @if ($errors->has('box_id'))
                                                            <span id="box_id-error" class="error text-danger" for="input-box_id">{{ $errors->first('box_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">Остаток*</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('balance_amount') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('balance_amount') ? ' is-invalid' : '' }}"
                                                            name="balance_amount"
                                                            id="input-balance_amount"
                                                            type="text"
                                                            placeholder="Остаток"
                                                            value={{ ! empty($boxBalance) ? $boxBalance->balance_amount : 0 }}
                                                        />
                                                        @if ($errors->has('balance_amount'))
                                                            <span id="balance_amount-error" class="error text-danger" for="input-balance_amount">{{ $errors->first('balance_amount') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">Расчетный остаток</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('calculated_balance') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('calculated_balance') ? ' is-invalid' : '' }}"
                                                            name="calculated_balance"
                                                            id="input-calculated_balance"
                                                            type="text"
                                                            readonly
                                                            value="{{ $boxBalance->calculated_balance ?? '' }}"
                                                        />
                                                        @if ($errors->has('calculated_balance'))
                                                            <span id="calculated_balance-error" class="error text-danger" for="input-calculated_balance">{{ $errors->first('calculated_balance') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-2 col-form-label">Разница</label>
                                                <div class="col-sm-7">
                                                    <div class="form-group{{ $errors->has('difference') ? ' has-danger' : '' }}">
                                                        <input
                                                            class="form-control{{ $errors->has('difference') ? ' is-invalid' : '' }}"
                                                            name="difference"
                                                            id="input-difference"
                                                            type="text"
                                                            readonly
                                                            value="{{ $boxBalance->difference ?? '' }}"
                                                        />
                                                        @if ($errors->has('difference'))
                                                            <span id="difference-error" class="error text-danger" for="input-difference">{{ $errors->first('difference') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            @include('box-balance.teh-field')
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('box-balance.offer')
    </div>
@endsection
