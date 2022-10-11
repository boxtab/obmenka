@extends('layouts.app', ['activePage' => 'box', 'titlePage' => 'Счета: Добавление/Редактирование'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('box.store') }}" autocomplete="off" id="form-box"
                          class="form-horizontal">
                        @csrf
                        <div class="card">
                            <div class="card-header card-header-success">
                                <h4 class="card-title">Счет</h4>
                                <p class="card-category">Добавление/Редактирование</p>
                            </div>

                            <div class="card-body">
                                @if(isset($box))
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">ID</label>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <input class="form-control" name="id" id="input-id"
                                                       type="text" readonly value="{{ $box->id ?? '' }}"/>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <label class="col-sm-2 col-form-label" for="input-type_box">Тип счета*</label>
                                    <div class="col-sm-10">
                                        <div class="form-group{{ $errors->has('type_box') ? ' has-danger' : '' }}">
                                            <input name="type_box" id="input-type_box-card" type="radio"
                                                   value="{{config('constants.type_box.card')}}" required="true"
                                                   {{ ( (old('type_box') === 'card') || (!empty ($box->type_box) && $box->type_box == 'card') ) ? 'checked' : '' }}
                                                   aria-required="true"/>
                                            <label for="input-type_box-card" class="col-sm-1 radio-inline">
                                                {{config('constants.type_box_ru.card')}}
                                            </label>
                                            <input name="type_box" id="input-type_box-wallet" type="radio"
                                                   value="{{config('constants.type_box.wallet')}}" required="true"
                                                   {{ ( (old('type_box') === 'wallet') || (!empty ($box->type_box) && $box->type_box == 'wallet') ) ? 'checked' : '' }}
                                                   aria-required="true"/>
                                            <label for="input-type_box-wallet" class="col-sm-1 radio-inline">
                                                {{config('constants.type_box_ru.wallet')}}
                                            </label>
                                            @if ($errors->has('type_box'))
                                                <span id="name-error" class="error text-danger" for="input-type_box">
                                                    {{ $errors->first('type_box') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label" for="input-unique_name">Уникальный
                                        номер*</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('unique_name') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('unique_name') ? ' is-invalid' : '' }}"
                                                name="unique_name"
                                                id="input-unique_name"
                                                type="text"
                                                placeholder="Наименование"
                                                value="{{ $box->unique_name ?? '' }}"
                                                required="true"
                                                aria-required="true"/>
                                            @if ($errors->has('unique_name'))
                                                <span id="name-error" class="error text-danger"
                                                      for="input-unique_name">{{ $errors->first('unique_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group form-group required">
                                        <label class="col-sm-2 col-form-label input-group-addon"
                                               for="select-direction_id">
                                            Направление*
                                        </label>
                                        <div class="col-sm-2">
                                            <select id="select-direction_id" name="direction_id"
                                                    class="selectpicker" data-style="btn btn-primary btn-round">
                                                <option disabled selected>Выберите из списка</option>
                                                @isset($listDirection)
                                                    @foreach($listDirection as $direction)
                                                        <option value="{{$direction->id}}"
                                                                @if(isset($box) && $box->direction_id === $direction->id )
                                                                selected
                                                            @endif>
                                                            {{$direction->paymentSystem->descr}} {{$direction->currency->descr}}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @if(isset($box))
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Дата создания</label>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <input class="form-control" name="created_at"
                                                       id="input-created_at" type="text" disabled
                                                       value="{{ $box->created_at ?? '' }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Дата редактирования</label>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <input class="form-control" name="updated_at"
                                                       id="input-updated_at" type="text" disabled
                                                       value="{{ $box->updated_at ?? '' }}"/>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer ml-auto mr-auto">
                                <div class="col-lg-6 text-left">
                                    <button type="submit" form="form-box" class="btn btn-primary">Сохранить</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <a href="{{ route('box.index') }}" class="btn btn-block" role="button">Назад</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
