@extends('layouts.app', ['activePage' => 'client', 'titlePage' => 'Клиенты'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Клиенты</h4>
                            <div class="card-actions ml-auto mr-auto">
                                <a href="{{route('client.create')}}"
                                   class="btn btn-primary"
                                   role="button">Добавить</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th class="icon">Открыть</th>
                                        <th>ID</th>
                                        <th>ФИО</th>
                                        <th>Почта</th>
                                        <th>Телефон</th>
                                        <th>Заметка</th>
                                        <th>Дата создания</th>
                                        <th>Дата изменения</th>
                                        <th>Кто добавил</th>
                                        <th>Кто изменил</th>
                                        <th class="icon">Удалить</th>
                                    </thead>
                                    <tbody>
                                        @isset($listClient)
                                            @foreach($listClient as $client)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('client.edit', ['client' => $client->id]) }}"
                                                           type="button" class="btn btn-primary btn-link btn-sm">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    </td>
                                                    <td>{{$client->id}}</td>
                                                    <td>{{$client->fullname}}</td>
                                                    <td>{{$client->email}}</td>
                                                    <td>{{$client->phone}}</td>
                                                    <td>{{$client->note}}</td>
                                                    <td>{{$client->created_at}}</td>
                                                    <td>{{$client->updated_at}}</td>
                                                    <td>{{$client->created_full_name}}</td>
                                                    <td>{{$client->updated_full_name}}</td>
                                                    <td>
                                                        <button type="button"
                                                                class="btn btn-danger btn-link btn-sm delete-confirm"
                                                                data-id="{{$client->id}}"
                                                                data-toggle="modal"
                                                                data-target="#deleteModal">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'client'])
    </div>
@endsection
