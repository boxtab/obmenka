@extends('layouts.app', ['activePage' => 'bid', 'titlePage' => 'Заявки'])

@push('js')
    <script src="{{ asset('js/bid/bid-list.js') }}?v=@version" defer></script>
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row" style="height: 50px">
                <div class="col-sm-9">
                    @include('bid.list-filter')
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Заявки</h4>
                            <div class="card-actions ml-auto mr-auto">
                                <a href="{{route('bid.export')}}" class="btn btn-primary">Экспорт</a>
                                <a href="{{route('bid.create')}}" class="btn btn-primary" role="button">Добавить</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table data-bid-list">
                                    <thead class=" text-primary">
                                        <th></th>
                                        <th>ID</th>
                                        <th># Заявки</th>
                                        <th>Источник доходов</th>
                                        <th>Получаем</th>
                                        <th>Сумма</th>
                                        <th>Отдаем</th>
                                        <th>Сумма</th>
                                        <th>Комментарий</th>
                                        <th>Дата редактирования</th>
                                        <th>Кто добавил</th>
                                        <th>Менеджер</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'bid'])
    </div>
@endsection

@section('summary-line')
    @include('summary-line')
@endsection
