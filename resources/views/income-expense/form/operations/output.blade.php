<br>
<div class="row">

    <div class="col-md-4">
        <div class="input-group form-group required">
            <label
                class="col-sm-4 col-lg-4 col-md-4 col-form-label input-group-addon control-label"
                for="select-box_income_id"
            >Бокс прихода</label>
            <div class="col-sm-8 col-lg-8 col-md-8">
                <select id="select-box_income_id"
                        name="box_income_id"
                        required="required"
                        class="selectpicker"
                        data-style="btn btn-primary btn-round">
                    <option disabled selected></option>
                    @isset($listBoxIncome)
                        @foreach($listBoxIncome as $boxIncome)
                            <option value="{{$boxIncome->id}}"
                                    @if(old('box_income_id') == $boxIncome->id)
                                    selected
                                    @elseif(isset($incomeExpense) &&
                                        $boxIncomeId == $boxIncome->id
                                        ) selected @endif>
                                {{$boxIncome->unique_name}}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mat-form-field-wrapper">
            <label for="input-amount_income" class="control-label">
                Сумма прихода
            </label>
            <div class="form-group{{ $errors->has('amount_income') ? ' has-danger' : '' }} required">
                <input
                    class="form-control{{ $errors->has('amount_income') ? ' is-invalid' : '' }}"
                    name="amount_income"
                    id="input-amount_income"
                    type="number"
                    min="0"
                    step="0.000000000001"
                    required="required"
                    aria-required="true"
                    value="{{ $amountIncome ?? '' }}">
                @if ($errors->has('amount_income'))
                    <span id="amount_income-error" class="error text-danger" for="input-amount_income">{{ $errors->first('amount_income') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mat-form-field-wrapper">
            <label for="input-rate_income" class="control-label control-label">
                Курс прихода
            </label>
            <div class="form-group{{ $errors->has('rate_income') ? ' has-danger' : '' }} required">
                <input
                    class="form-control"
                    name="rate_income"
                    id="input-rate_income"
                    type="number"
                    min="0"
                    step="0.00000001"
                    required="required"
                    aria-required="true"
                    value="{{ $rateIncome ?? '' }}">
                @if ($errors->has('rate_income'))
                    <span id="rate_income-error" class="error text-danger" for="input-rate_income">{{ $errors->first('rate_income') }}</span>
                @endif
            </div>
        </div>
    </div>

</div>

<br>
<div class="row">
    <label for="input-expense_id" class="col-sm-2 col-md-2 col-lg-2 col-form-label">ID расхода</label>
    <div class="col-sm-10 col-md-10 col-lg-10">
        <div class="form-group">
            <input
                class="form-control"
                name="expense_id"
                id="input-expense_id"
                type="text"
                readonly
                value="{{ $expenseId ?? '' }}"/>
        </div>
    </div>
</div>
<br>

<div class="row">

    <div class="col-md-4">
        <div class="input-group form-group required">
            <label
                class="col-sm-4 col-lg-4 col-md-4 col-form-label input-group-addon control-label"
                for="select-box_expense_id"
            >Бокс расхода</label>
            <div class="col-sm-8 col-lg-8 col-md-8">
                <select id="select-box_expense_id"
                        name="box_expense_id"
                        required="required"
                        aria-required="true"
                        class="selectpicker"
                        data-style="btn btn-primary btn-round">
                    <option disabled selected></option>
                    @isset($listBoxExpense)
                        @foreach($listBoxExpense as $boxExpense)
                            <option value="{{$boxExpense->id}}"
                                    @if(old('box_expense_id') == $boxExpense->id)
                                    selected
                                    @elseif(isset($incomeExpense) &&
                                        $boxExpenseId === $boxExpense->id
                                        ) selected @endif>
                                {{$boxExpense->unique_name}}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mat-form-field-wrapper">
            <label for="input-expense_income" class="control-label">
                Сумма расхода
            </label>
            <div class="form-group{{ $errors->has('amount_expense') ? ' has-danger' : '' }} required">
                <input
                    class="form-control{{ $errors->has('amount_expense') ? ' is-invalid' : '' }} required"
                    name="amount_expense"
                    id="input-amount_expense"
                    type="number"
                    min="0"
                    step="0.000000000001"
                    required="required"
                    aria-required="true"
                    value="{{ $amountExpense ?? '' }}">
                @if ($errors->has('amount_expense'))
                    <span id="amount_expense-error" class="error text-danger" for="input-amount_expense">{{ $errors->first('amount_expense') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mat-form-field-wrapper">
            <label for="input-rate_expense" class="control-label">
                Курс расхода
            </label>
            <div class="form-group{{ $errors->has('rate_expense') ? ' has-danger' : '' }} required">
                <input
                    class="form-control"
                    name="rate_expense"
                    id="input-rate_expense"
                    type="number"
                    min="0"
                    step="0.00000001"
                    required
                    aria-required="true"
                    value="{{ $rateExpense ?? '' }}">
                @if ($errors->has('rate_expense'))
                    <span id="rate_expense-error" class="error text-danger" for="input-rate_expense">{{ $errors->first('rate_expense') }}</span>
                @endif
            </div>
        </div>
    </div>

</div>
