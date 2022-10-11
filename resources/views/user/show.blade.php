@extends('layouts.app', ['activePage' => 'user', 'titlePage' => 'Пользователи: Добавление/Редактирование'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post"
                          action="{{ route('user.store') }}"
                          autocomplete="off"
                          id="form-user"
                          class="form-horizontal">
                        @csrf
                        <div class="card ">
                            <div class="card-header card-header-success">
                                <h4 class="card-title">Пользователь</h4>
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
                                                value="{{ $user->id ?? '' }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Фамилия*</label>
                                    <div class="col-sm-7">
                                            <input
                                                class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}"
                                                name="surname"
                                                id="input-surname"
                                                type="text"
                                                placeholder="Фамилия"
                                                value="{{ $user->surname ?? old('surname') ?? '' }}"
{{--                                                required="true"--}}
                                                maxlength="255"
                                                autocomplete="off"
                                                aria-required="true"/>
                                            @if ($errors->has('surname'))
                                                <span id="surname-error" class="error text-danger" for="input-surname">{{ $errors->first('surname') }}</span>
                                            @endif
                                        </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Имя*</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                name="name"
                                                id="input-name"
                                                type="text"
                                                placeholder="Имя"
                                                value="{{ $user->name ?? old('name') ?? '' }}"
                                                required="true"
                                                maxlength="255"
                                                autocomplete="off"
                                                aria-required="true"/>
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Отчество*</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('patronymic') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('patronymic') ? ' is-invalid' : '' }}"
                                                name="patronymic"
                                                id="input-patronymic"
                                                type="text"
                                                placeholder="Отчество"
                                                value="{{ $user->patronymic ?? old('patronymic') ?? '' }}"
                                                required="true"
                                                maxlength="255"
                                                autocomplete="off"
                                                aria-required="true"/>
                                            @if ($errors->has('patronymic'))
                                                <span id="patronymic-error" class="error text-danger" for="input-patronymic">{{ $errors->first('patronymic') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Дата рождения*</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('birthday') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}"
                                                name="birthday"
                                                id="input-birthday"
                                                type="date"
                                                placeholder="Дата рождения"
                                                value="{{ $user->birthday ?? old('birthday') ?? '' }}"
                                                required="true"
                                                maxlength="255"
                                                autocomplete="off"
                                                aria-required="true"/>
                                            @if ($errors->has('birthday'))
                                                <span id="birthday-error" class="error text-danger" for="input-birthday">{{ $errors->first('birthday') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Email*</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                name="email"
                                                id="input-email"
                                                type="email"
                                                placeholder="Email"
                                                value="{{ $user->email ?? old('email') ?? '' }}"
                                                required="true"
                                                autocomplete="off"
                                                aria-required="true"/>
                                            @if ($errors->has('email'))
                                                <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Пароль*</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                name="password"
                                                id="input-password"
                                                type="password"
                                                placeholder="Password"
{{--                                                value="{{ $user->password ?? '' }}"--}}
                                                required="true"
                                                autocomplete="off"
                                                aria-required="true"/>
                                            @if ($errors->has('password'))
                                                <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Подтверждение пароля*</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                                name="password_confirmation"
                                                id="input-password_confirmation"
                                                type="password"
                                                placeholder="Confirm Password"
{{--                                                value="{{ $user->password ?? '' }}"--}}
                                                required="true"
                                                autocomplete="off"
                                                aria-required="true"/>
                                            @if ($errors->has('password_confirmation'))
                                                <span id="password_confirmation-error" class="error text-danger" for="input-password_confirmation">{{ $errors->first('password_confirmation') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label" for="work">Работает?*</label>
                                    <div class="col-sm-10">
                                        <div class="form-group{{ $errors->has('work') ? ' has-danger' : '' }}">
                                            <input
                                                name="work"
                                                id="input-work-yes"
                                                type="radio"
                                                value="yes"
                                                required="true"
                                                autocomplete="off"
                                                {{ (!empty ($user->work) && $user->work == 'yes') ? 'checked' : '' }}
                                                aria-required="true"/>
                                            <label for="input-work-yes" class="col-sm-1 radio-inline">
                                                Да
                                            </label>
                                            <input
                                                name="work"
                                                id="input-work-no"
                                                type="radio"
                                                value="no"
                                                required="true"
                                                autocomplete="off"
                                                {{ (!empty ($user->work) && $user->work == 'no') ? 'checked' : '' }}
                                                aria-required="true"/>
                                            <label for="input-work-no" class="col-sm-1 radio-inline">
                                                Нет
                                            </label>
                                            @if ($errors->has('work'))
                                                <span id="name-error"
                                                      class="error text-danger"
                                                      for="input-work">{{ $errors->first('work') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group form-group required">
                                        <label
                                            class="col-sm-2 col-form-label input-group-addon"
                                            for="select-role_id"
                                        >Роль*</label>
                                        <div class="col-sm-2">
                                            <select id="select-role_id"
                                                    name="role_id"
                                                    required
                                                    class="selectpicker"
                                                    autocomplete="off"
                                                    data-style="btn btn-primary btn-round">
                                                <option disabled selected>Выберите из списка</option>
                                                @foreach($listRole as $role)
                                                    <option value="{{$role->id}}"
                                                            @if(old('role_id') == $role->id)
                                                            selected
                                                            @elseif(isset($user) &&
                                                                $user->role_id === $role->id
                                                                ) selected @endif>
                                                        {{$role->descr}}
                                                    </option>
                                                @endforeach
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
                                                value="{{ $user->created_at ?? '' }}"/>
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
                                                value="{{ $user->updated_at ?? '' }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <div class="col-lg-6 text-left">
                                    <button type="submit" form="form-user" class="btn btn-primary">Сохранить</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <a href="{{ route('user.index') }}" class="btn btn-block" role="button">Назад</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
