@extends('layouts.app', ['activePage' => 'role', 'titlePage' => 'Роль'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title ">Роль</h4>
                        <div class="card-actions ml-auto mr-auto">
                            <a href="{{route('role.create')}}"
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
                                    <th>Роль</th>
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Удалить</th>
                                </thead>
                                <tbody>
                                @foreach($listRole as $role)
                                    <tr>
                                        <td>
                                            <a href="{{ route('role.edit', ['role' => $role->id]) }}"
                                               type="button"
                                               rel="tooltip"
                                               title="Редактировать"
                                               class="btn btn-primary btn-link btn-sm">
                                                <i class="material-icons">edit</i>
                                            </a>
                                        </td>
                                        <td>{{$role->id}}</td>
                                        <td>{{$role->descr}}</td>
                                        <td>{{$role->created_at}}</td>
                                        <td>{{$role->updated_at}}</td>
                                        <td>
                                        @if($role->id === 1)
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
                                                    class="btn btn-danger btn-link btn-sm delete-confirm"
                                                    rel="tooltip"
                                                    data-id="{{$role->id}}"
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
    @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'role'])
    @include('books.role.modal-admin')
</div>
@endsection
