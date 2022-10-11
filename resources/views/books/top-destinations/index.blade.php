@extends('layouts.app', ['activePage' => 'top-destinations', 'titlePage' => 'Источники дохода'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title ">Источники дохода</h4>
                        <div class="card-actions ml-auto mr-auto">
                            <a href="{{route('top-destinations.create')}}"
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
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Кто добавил</th>
                                    <th>Кто изменил</th>
                                    <th>Удалить</th>
                                </thead>
                                <tbody>
                                @foreach($listTopDestinations as $topDestinations)
                                    <tr>
                                        <td>
                                            <a href="{{ route('top-destinations.edit', ['topDestinations' => $topDestinations->id]) }}"
                                               type="button"
                                               rel="tooltip"
                                               title="Редактировать"
                                               class="btn btn-primary btn-link btn-sm">
                                                <i class="material-icons">edit</i>
                                            </a>
                                        </td>
                                        <td>{{$topDestinations->id}}</td>
                                        <td>{{$topDestinations->descr}}</td>
                                        <td>{{$topDestinations->created_at}}</td>
                                        <td>{{$topDestinations->updated_at}}</td>
                                        <td>{{$topDestinations->createdUser['surname'] . ' ' . mb_substr($topDestinations->createdUser['name'], 0, 1) . '. ' . mb_substr($topDestinations->createdUser['patronymic'], 0, 1) . '.'}}</td>
                                        <td>{{$topDestinations->updatedUser['surname'] . ' ' . mb_substr($topDestinations->updatedUser['name'], 0, 1) . '. ' . mb_substr($topDestinations->updatedUser['patronymic'], 0, 1) . '.'}}</td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn btn-danger btn-link btn-sm delete-confirm"
                                                rel="tooltip"
                                                data-id="{{$topDestinations->id}}"
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
    @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'top-destinations'])
</div>
@endsection
