@extends('layouts.app', ['activePage' => 'top-destinations', 'titlePage' => 'Источники дохода: Добавление/Редактирование'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post"
                          action="{{ route('top-destinations.store') }}"
                          autocomplete="off"
                          id="form-top-destinations"
                          class="form-horizontal">
                        @csrf
                        <div class="card ">
                            <div class="card-header card-header-success">
                                <h4 class="card-title">Источники дохода</h4>
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
                                                value="{{ $topDestinations->id ?? '' }}"/>
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
                                                value="{{ $topDestinations->descr ?? '' }}"
                                                required="true"
                                                aria-required="true"/>
                                            @if ($errors->has('descr'))
                                                <span id="name-error" class="error text-danger" for="input-descr">{{ $errors->first('descr') }}</span>
                                            @endif
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
                                                value="{{ $topDestinations->created_at ?? '' }}"/>
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
                                                value="{{ $topDestinations->updated_at ?? '' }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <div class="col-lg-6 text-left">
                                    <button type="submit" form="form-top-destinations" class="btn btn-primary">Сохранить</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <a href="{{ route('top-destinations.index') }}" class="btn btn-block" role="button">Назад</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
