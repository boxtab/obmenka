@extends('layouts.app', ['activePage' => 'user', 'titlePage' => 'Пользователи'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Пользователи</h4>
                            <div class="card-actions ml-auto mr-auto">
                                <a href="{{route('user.create')}}"
                                   class="btn btn-primary"
                                   role="button">Добавить</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <th>Открыть</th>
                                    <th>ID</th>
                                    <th>ФИО</th>
                                    <th>Дата рождения</th>
                                    <th>Email</th>
                                    <th>Работает?</th>
                                    <th>Роль</th>
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Удалить</th>
                                    </thead>
                                    <tbody>
                                    @foreach($listUser as $user)
                                        <tr class=" @if($user->work !== 'yes')table-danger @endif">
                                            <td>
                                                <a href="{{ route('user.edit', ['user' => $user->id]) }}"
                                                   type="button"
                                                   rel="tooltip"
                                                   title="Редактировать"
                                                   class="btn btn-primary btn-link btn-sm">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            </td>
                                            <td>{{$user->id}}</td>
                                            <td>{{$user->full_name}}</td>
                                            <td>{{$user->birthday}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->is_work}}</td>
                                            <td>{{$user->role->descr ?? ''}}</td>
                                            <td>{{$user->created_at}}</td>
                                            <td>{{$user->updated_at}}</td>
                                            <td>
                                                @if($user->role_id === 1)
                                                    <!-- Button trigger modal -->
                                                    <button
                                                        type="button"
                                                        class="btn btn-danger btn-link btn-sm"
                                                        rel="tooltip"
                                                        data-toggle="modal"
                                                        data-target="#adminModal">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                @else
                                                    <button
                                                        type="button"
                                                        class="btn btn-danger btn-link btn-sm"
                                                        rel="tooltip"
                                                        data-toggle="modal"
                                                        data-target="#deleteModal">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('user.modal-admin')
        @include('user.modal-delete')
    </div>
@endsection
