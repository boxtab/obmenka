@extends('layouts.app', ['activePage' => 'top-destinations-group', 'titlePage' => 'Группы источников дохода'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Группы источников дохода</h4>
                            <div class="card-actions ml-auto mr-auto">
                                <a href="{{route('top-destinations-group.create')}}"
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
                                        <th>Месяц, год</th>
                                        <th>Список источников дохода</th>
                                        <th>Дата создания</th>
                                        <th>Дата изменения</th>
                                        <th>Кто добавил</th>
                                        <th>Кто изменил</th>
                                        <th>Удалить</th>
                                    </thead>
                                    <tbody>
                                    @isset($listTopDestinationsGroup)
                                        @foreach($listTopDestinationsGroup as $topDestinationsGroup)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('top-destinations-group.edit',
                                                        ['topDestinationsGroup' => $topDestinationsGroup->id]) }}"
                                                       type="button"
                                                       rel="tooltip"
                                                       title="Редактировать"
                                                       class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                </td>
                                                <td>{{ $topDestinationsGroup->id }}</td>
                                                <td>{{ $topDestinationsGroup->description }}</td>
                                                <td>{{ $topDestinationsGroup->month_year }}</td>
                                                <td>{{ $topDestinationsGroup->top_destinations }}</td>
                                                <td>{{ $topDestinationsGroup->created_at }}</td>
                                                <td>{{ $topDestinationsGroup->updated_at }}</td>
                                                <td>{{ $topDestinationsGroup->created_full_name }}</td>
                                                <td>{{ $topDestinationsGroup->updated_full_name }}</td>
                                                <td>
                                                    <button
                                                        type="button"
                                                        class="btn btn-danger btn-link btn-sm delete-confirm"
                                                        rel="tooltip"
                                                        data-id="{{$topDestinationsGroup->id}}"
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
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'top-destinations-group'])
    </div>
@endsection
