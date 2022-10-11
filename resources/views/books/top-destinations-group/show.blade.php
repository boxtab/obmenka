@extends('layouts.app', ['activePage' => 'top-destinations-group', 'titlePage' => 'Группы источников дохода: Добавление/Редактирование'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post"
                          action="{{ route('top-destinations-group.store') }}"
                          autocomplete="off"
                          id="form-top-destinations-group"
                          class="form-horizontal">
                        @csrf
                        <div class="card ">
                            <div class="card-header card-header-success">
                                <h4 class="card-title">Группы источников дохода</h4>
                                <p class="card-category">Добавление/Редактирование</p>
                            </div>
                            <div class="card-body ">
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
                                                value="{{ $topDestinationsGroup->id ?? '' }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Наименование*</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                                name="description"
                                                id="input-description"
                                                type="text"
                                                placeholder="Наименование"
                                                value="{{ $topDestinationsGroup->description ?? '' }}"
                                                required="true"
                                                aria-required="true"/>
                                            @if ($errors->has('description'))
                                                <span id="name-error" class="error text-danger" for="input-description">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Месяц, год*</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('month_year') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('month_year') ? ' is-invalid' : '' }}"
                                                name="month_year"
                                                id="input-month_year"
                                                type="month"
                                                required="true"
                                                aria-required="true"
                                                value="{{ $topDestinationsGroup->month_year_format ?? '' }}"
                                            />
                                            @if ($errors->has('month_year'))
                                                <span id="name-error" class="error text-danger" for="input-month_year">{{ $errors->first('month_year') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group form-group required">
                                        <label
                                            class="col-sm-2 col-form-label input-group-addon control-label"
                                            for="select_top_destinations"
                                        >Источники доходов</label>
                                        <div class="col-sm-10">
                                            <select id="select_top_destinations"
                                                    name="top_destinations[]"
                                                    required="required"
                                                    aria-required="true"
{{--                                                    class="selectpicker"--}}
                                                    data-style="btn btn-success btn-round"
                                                    multiple>
{{--                                                <option disabled selected></option>--}}
                                                @isset($listTopDestinations)
                                                    @foreach($listTopDestinations as $topDestinations)
                                                        <option
                                                                @isset ( $listTopDestinationsSelected )
                                                                    @if( in_array( $topDestinations->id, $listTopDestinationsSelected ) )
                                                                        selected
                                                                    @endif
                                                                @endisset
                                                                value="{{$topDestinations->id}}">
                                                            {{ $topDestinations->descr }}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Дата создания</label>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <input
                                                class="form-control"
                                                name="created_at"
                                                id="input-created_at"
                                                type="text"
                                                disabled
                                                value="{{ $topDestinationsGroup->created_at ?? '' }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Дата редактирования</label>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <input
                                                class="form-control"
                                                name="updated_at"
                                                id="input-updated_at"
                                                type="text"
                                                disabled
                                                value="{{ $topDestinationsGroup->updated_at ?? '' }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <div class="col-lg-6 text-left">
                                    <button type="submit" form="form-top-destinations-group" class="btn btn-primary">Сохранить</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <a href="{{ route('top-destinations-group.index') }}" class="btn btn-block" role="button">Назад</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
