@extends('layouts.app', ['activePage' => 'direction', 'titlePage' => 'Направление'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Направление</h4>
                            <div class="card-actions ml-auto mr-auto">
                                <a href="{{route('direction.create')}}"
                                   class="btn btn-primary"
                                   role="button">Добавить</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>Открыть</th>
                                        <th>ID</th>
                                        <th>Платежная система</th>
                                        <th>Код валюты</th>
                                        <th>Дата создания</th>
                                        <th>Дата изменения</th>
                                        <th>Кто добавил</th>
                                        <th>Кто изменил</th>
                                        <th>Удалить</th>
                                    </thead>
                                    <tbody>
                                    @foreach($listDirection as $direction)
                                        <tr>
                                            <td>
                                                <a href="{{ route('direction.edit', ['direction' => $direction->id]) }}"
                                                   type="button" rel="tooltip" title="Редактировать"
                                                   class="btn btn-primary btn-link btn-sm">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            </td>
                                            <td>{{$direction->id}}</td>
                                            <td>{{$direction->paymentSystem->descr}}</td>
                                            <td>{{$direction->currency->descr}}</td>
                                            <td>{{$direction->created_at}}</td>
                                            <td>{{$direction->updated_at}}</td>
                                            <td>{{$direction->created_full_name}}</td>
                                            <td>{{$direction->updated_full_name}}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-danger btn-link btn-sm delete-confirm"
                                                    rel="tooltip"
                                                    data-id="{{$direction->id}}"
                                                    data-toggle="modal"
                                                    data-target="#deleteModal">
                                                    <i class="material-icons">close</i>
                                                </button>
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
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'direction'])
    </div>
@endsection
