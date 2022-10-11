@extends('layouts.app', ['activePage' => 'income-expense', 'titlePage' => 'Приход/Расход: Добавление/Редактирование'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <form method="post"
                          action="{{ route('income-expense.store') }}"
                          autocomplete="off"
                          id="form-income-expense"
                          class="form-horizontal">
                        @csrf
                        <div class="card">
                            <div class="card-header card-header-success">
                                <h4 class="card-title">Приход/Расход: {{ $operationTitleName ?? '' }}</h4>
                                <p class="card-category">Добавление/Редактирование</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <label for="input-id" class="col-sm-2 col-md-2 col-lg-2 col-form-label">ID</label>
                                    <div class="col-sm-10 col-md-10 col-lg-10">
                                        <div class="form-group">
                                            <input
                                                class="form-control"
                                                name="id"
                                                id="input-id"
                                                type="text"
                                                readonly
                                                value="{{ $incomeId ?? $incomeExpense->id ?? '' }}"/>
                                            <input type="hidden" name="income_expense_type_id" value="{{ $incomeExpenseTypeId }}">
                                        </div>
                                    </div>
                                </div>
                                @include('income-expense.form.operations.' . $operationTemplateName)
                                @include('income-expense.form.note')
                                @include('income-expense.form.teh-field')
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <div class="col-lg-6 text-left">
                                    <button type="submit" form="form-income-expense" class="btn btn-primary">Сохранить</button>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <a href="{{ route('income-expense.index') }}" class="btn btn-block" role="button">Назад</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
