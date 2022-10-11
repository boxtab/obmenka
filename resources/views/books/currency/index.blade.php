@extends('layouts.app', ['activePage' => 'currency', 'titlePage' => 'Коды валют'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Коды валют</h4>
                            <div class="card-actions ml-auto mr-auto">
                                <a href="{{route('currency.create')}}"
                                   class="btn btn-primary"
                                   role="button">Добавить</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <th></th>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Кто добавил</th>
                                    <th>Кто изменил</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    @foreach($listCurrency as $currency)
                                        <tr>
                                            <td>
                                                <a href="{{ route('currency.edit', ['currency' => $currency->id]) }}"
                                                   type="button"
                                                   rel="tooltip"
                                                   title="Редактировать"
                                                   class="btn btn-primary btn-link btn-sm">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            </td>
                                            <td>{{$currency->id}}</td>
                                            <td>{{$currency->descr}}</td>
                                            <td>{{$currency->created_at}}</td>
                                            <td>{{$currency->updated_at}}</td>
                                            <td>{{$currency->createdUser['surname'] . ' ' . mb_substr($currency->createdUser['name'], 0, 1) . '. ' . mb_substr($currency->createdUser['patronymic'], 0, 1) . '.'}}</td>
                                            <td>{{$currency->updatedUser['surname'] . ' ' . mb_substr($currency->updatedUser['name'], 0, 1) . '. ' . mb_substr($currency->updatedUser['patronymic'], 0, 1) . '.'}}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-danger btn-link btn-sm delete-confirm"
                                                    rel="tooltip"
                                                    data-id="{{$currency->id}}"
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
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'currency'])
    </div>
@endsection
