@extends('layouts.app', ['activePage' => 'dds', 'titlePage' => 'Справочник Движение денежных средств'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Справочник Движения денежных средств</h4>
                            <div class="card-actions ml-auto mr-auto">
                                <a href="{{route('dds.create')}}"
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
                                        <th>Название</th>
                                        <th>Источник дохода</th>
                                        <th>Дата создания</th>
                                        <th>Дата изменения</th>
                                        <th>Кто добавил</th>
                                        <th>Кто изменил</th>
                                        <th>Удалить</th>
                                    </thead>
                                    <tbody>
                                        @foreach( $listDDS as $dds )
                                            <tr>
                                                <td>
                                                    <a href="{{ route('dds.edit', ['dds' => $dds->id]) }}"
                                                       type="button"
                                                       rel="tooltip"
                                                       title="Редактировать"
                                                       class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                </td>
                                                <td>{{ $dds->id }}</td>
                                                <td>{{ $dds->descr }}</td>
                                                <td>{{ $dds->topdestinations->descr }}</td>
                                                <td>{{ $dds->created_at }}</td>
                                                <td>{{ $dds->updated_at }}</td>
                                                <td>{{ $dds->created_full_name }}</td>
                                                <td>{{ $dds->updated_full_name }}</td>
                                                <td>
                                                    <button
                                                        type="button"
                                                        class="btn btn-danger btn-link btn-sm delete-confirm"
                                                        rel="tooltip"
                                                        data-id="{{$dds->id}}"
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
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'dds'])
    </div>
@endsection
