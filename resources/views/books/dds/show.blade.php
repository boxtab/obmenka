@extends('layouts.app', ['activePage' => 'dds', 'titlePage' => 'Справочник движения денежных средств: Добавление/Редактирование'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post"
                          action="{{ route('dds.store') }}"
                          autocomplete="off"
                          id="form-dds"
                          class="form-horizontal">
                        @csrf
                        <div class="card ">
                            <div class="card-header card-header-success">
                                <h4 class="card-title">Справочник движения денежных средств</h4>
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
                                                value="{{ $dds->id ?? '' }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Наименование*</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('descr') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('descr') ? ' is-invalid' : '' }}"
                                                name="descr"
                                                id="input-descr"
                                                type="text"
                                                placeholder="Наименование"
                                                value="{{ $dds->descr ?? '' }}"
                                                required="true"
                                                maxlength="255"
                                                aria-required="true"/>
                                            @if ($errors->has('descr'))
                                                <span id="name-error" class="error text-danger" for="input-descr">{{ $errors->first('descr') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-form-label">
                                        <div class="input-group form-group">
                                            <label
                                                class="col-sm-4 col-lg-4 col-md-4 col-form-label input-group-addon"
                                                for="select_top_destinations_id"
                                            >Источник дохода</label>
                                            <div class="col-sm-8 col-lg-8 col-md-8">
                                                <select id="select_top_destinations_id"
                                                        name="top_destinations_id"
                                                        class="selectpicker"
                                                        data-style="btn btn-success btn-round">
                                                    <option value=""></option>
                                                    @isset( $listTopDestinations )
                                                        @foreach($listTopDestinations as $topDestinations)
                                                            <option value="{{$topDestinations->id}}"
                                                                    @if(old('top_destinations_id') == $topDestinations->id)
                                                                    selected
                                                                    @elseif(isset($dds) &&
                                                                        $dds->top_destinations_id === $topDestinations->id
                                                                        ) selected @endif>
                                                                {{$topDestinations->descr}}
                                                            </option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </div>
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
                                                value="{{ $dds->created_at ?? '' }}"/>
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
                                                value="{{ $dds->updated_at ?? '' }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <div class="col-lg-6 text-left">
                                    <button type="submit" form="form-dds" class="btn btn-primary">Сохранить</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <a href="{{ route('dds.index') }}" class="btn btn-block" role="button">Назад</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
