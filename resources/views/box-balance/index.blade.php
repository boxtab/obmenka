@extends('layouts.app', ['activePage' => 'box-balance', 'titlePage' => 'Остатки'])

@push('js')
{{--    <script src="{{ asset('js/box-balance/list.js') }}?v=@version" defer></script>--}}
    <script src="{{ asset('js/box-balance/update-amount.js') }}?v=@version" defer></script>
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Остатки</h4>
                            <div class="card-actions ml-auto mr-auto">
                                <a href="{{route('box-balance.export')}}" class="btn btn-primary">Экспорт</a>
                                <a href="{{route('box-balance.create')}}"
                                   class="btn btn-primary"
                                   role="button">Добавить</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('box-balance.panel-tools')
                            <div class="table-responsive">
                                <table class="table table-bordered yajra-datatable" id="box-balance-table">
                                    <thead class="text-primary">
                                        <th></th>
                                        <th>ID</th>
                                        <th>Дата</th>
                                        <th>Счет</th>
                                        <th>Остаток</th>
                                        <th>Рассчитано</th>
                                        <th>Разница</th>
                                        <th>Дата изменения</th>
                                        <th>Кто добавил</th>
                                        <th>Кто изменил</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @isset( $listBoxBalance )
                                            @foreach( $listBoxBalance as $boxBalance )
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('box-balance.edit', ['boxBalance' => $boxBalance->id]) }}">Открыть</a>
                                                    </td>
                                                    <td>{{ $boxBalance->id }}</td>
                                                    <td>{{ $boxBalance->balance_date }}</td>
                                                    <td>{{ $boxBalance->box->unique_name }}</td>
                                                    <td><input type="text" data-id="{{$boxBalance->id}}" class="balance-amount" value="{{ $boxBalance->balance_amount ?? ''}}"></td>
{{--                                                    <td>{{ $boxBalance->balance_amount }}</td>--}}
                                                    <td>{{ $boxBalance->calculated_balance }}</td>
                                                    <td>{{ $boxBalance->difference }}</td>
                                                    <td>{{ $boxBalance->updated_at }}</td>
                                                    <td>{{ $boxBalance->created_full_name }}</td>
                                                    <td>{{ $boxBalance->updated_full_name }}</td>
                                                    <td>
                                                        <a
                                                            class="delete-confirm"
                                                            data-id="{{ $boxBalance->id }}"
                                                            data-toggle="modal"
                                                            data-target="#deleteModal">
                                                            Удалить
                                                        </a>
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
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'box-balance/destroy'])
    </div>
@endsection

