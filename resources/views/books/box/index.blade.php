@extends('layouts.app', ['activePage' => 'box', 'titlePage' => 'Счета'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Счета</h4>
                            <div class="card-actions ml-auto mr-auto">
                                <a href="{{route('box.create')}}"
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
                                        <th>Тип</th>
                                        <th>Уникальное имя</th>
                                        <th>Направление</th>
                                        <th>Дата создания</th>
                                        <th>Дата изменения</th>
                                        <th>Кто добавил</th>
                                        <th>Кто изменил</th>
                                        <th>Удалить</th>
                                    </thead>
                                    <tbody>
                                        @isset( $listBox )
                                            @foreach($listBox as $box)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('box.edit', ['box' => $box->id]) }}" type="button"
                                                           rel="tooltip" title="Редактировать"
                                                           class="btn btn-primary btn-link btn-sm">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    </td>
                                                    <td>{{$box->id}}</td>
                                                    <td>{{$box->type_box_descr_ru}}</td>
                                                    <td>{{$box->unique_name}}</td>
                                                    <td>{{$box->direction_descr}}</td>
                                                    <td>{{$box->created_at}}</td>
                                                    <td>{{$box->updated_at}}</td>
                                                    <td>{{$box->created_full_name}}</td>
                                                    <td>{{$box->updated_full_name}}</td>
                                                    <td>
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger btn-link btn-sm delete-confirm"
                                                            rel="tooltip"
                                                            data-id="{{$box->id}}"
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
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'box'])
    </div>
@endsection
