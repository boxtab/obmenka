@extends('layouts.app', ['activePage' => 'income-expense', 'titlePage' => 'Приход/Расход'])

@push('js')
    <script src="{{ asset('js/income-expense/list.js') }}?v=@version" defer></script>
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row" style="height: 60px">
                <div class="col-sm-9">
                    @include('income-expense.list.list-filter')
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Приход/Расход</h4>
                            <div class="card-actions ml-auto mr-auto">
                                @include('income-expense.list.button')
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table data-income-expense-list">
                                    <thead class="text-primary">
                                        <th></th>
                                        <th>ID</th>
                                        <th>ПриходРасход</th>
                                        <th>Вид операции</th>
                                        <th>Код ДДС</th>
                                        <th>Бокс</th>
                                        <th>Сумма</th>
                                        <th>Курс к рублю</th>
                                        <th>Сумма в рублях</th>
                                        <th>Дата изменения</th>
                                        <th>Кто изменил</th>
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
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'income-expense'])
    </div>
@endsection

