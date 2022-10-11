@extends('layouts.app', ['activePage' => 'payment-system', 'titlePage' => 'Справочник платежных систем'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Справочник платежных систем</h4>
                            <div class="card-actions ml-auto mr-auto">
                                <a href="{{route('payment-system.create')}}"
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
                                    @foreach($listPaymentSystem as $paymentSystem)
                                        <tr>
                                            <td>
                                                <a href="{{ route('payment-system.edit', ['paymentSystem' => $paymentSystem->id]) }}"
                                                   type="button"
                                                   rel="tooltip"
                                                   title="Редактировать"
                                                   class="btn btn-primary btn-link btn-sm">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            </td>
                                            <td>{{$paymentSystem->id}}</td>
                                            <td>{{$paymentSystem->descr}}</td>
                                            <td>{{$paymentSystem->created_at}}</td>
                                            <td>{{$paymentSystem->updated_at}}</td>
                                            <td>{{$paymentSystem->createdUser['surname'] . ' ' . mb_substr($paymentSystem->createdUser['name'], 0, 1) . '. ' . mb_substr($paymentSystem->createdUser['patronymic'], 0, 1) . '.'}}</td>
                                            <td>{{$paymentSystem->updatedUser['surname'] . ' ' . mb_substr($paymentSystem->updatedUser['name'], 0, 1) . '. ' . mb_substr($paymentSystem->updatedUser['patronymic'], 0, 1) . '.'}}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-danger btn-link btn-sm delete-confirm"
                                                    rel="tooltip"
                                                    data-id="{{$paymentSystem->id}}"
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
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'payment-system'])
    </div>
@endsection
