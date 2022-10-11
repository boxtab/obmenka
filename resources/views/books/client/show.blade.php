@extends('layouts.app', ['activePage' => 'client', 'titlePage' => 'Клиенты: Добавление/Редактирование'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('client.store') }}" autocomplete="off"
                          class="form-horizontal">
                        @csrf
                        <div class="card ">
                            <div class="card-header card-header-success">
                                <h4 class="card-title">Клиент</h4>
                                <p class="card-category">Добавление/Редактирование</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <label class="col-md-2 col-form-label">ID</label>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <input class="form-control"
                                                   type="text"
                                                   name="id"
                                                   id="input-id"
                                                   readonly
                                                   value="{{ $client->id ?? old('id') ?? '' }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">ФИО</label>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <input class="form-control"
                                                   type="text"
                                                   name="fullname"
                                                   id="input-fullname"
                                                   placeholder="ФИО"
                                                   value="{{ $client->fullname ?? old('fullname') ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Email</label>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <input class="form-control"
{{--                                                   type="email"--}}
                                                   type="text"
                                                   name="email"
                                                   id="input-email"
                                                   placeholder="Email"
                                                   value="{{ $client->email ?? old('email') ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Телефон</label>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <input class="form-control"
                                                   type="text"
                                                   name="phone"
                                                   id="input-phone"
                                                   placeholder="Телефон"
                                                   value="{{ $client->phone ?? old('phone') ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-form-label">Комментарий</label>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <input class="form-control"
                                                   type="text"
                                                   name="note"
                                                   id="input-note"
                                                   placeholder="Комментарий"
                                                   value="{{ $client->note ?? old('note') ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Дата создания</label>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <input class="form-control"
                                                   type="text"
                                                   name="created_at"
                                                   id="input-created_at"
                                                   disabled
                                                   value="{{ $client->created_at ?? '' }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Дата редактирования</label>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <input class="form-control"
                                                   type="text"
                                                   name="updated_at"
                                                   id="input-updated_at"
                                                   disabled
                                                   value="{{ $client->updated_at ?? '' }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <div class="col-lg-6 text-left">
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <a href="{{ route('client.index') }}" class="btn btn-block" role="button">Назад</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
