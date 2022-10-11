<div class="row">
    <label class="col-sm-2 col-form-label required control-label" for="input-income_expense">Приход/Расход</label>
    <div class="col-sm-10">
        <div class="form-group{{ $errors->has('income_expense') ? ' has-danger' : '' }} required">
            <input
                name="income_expense"
                id="input-income_expense-income"
                type="radio"
                value="income"
                required="true"
                {{ (!empty ($incomeExpense->income_expense) && $incomeExpense->income_expense == "income") ? "checked" : "" }}
                aria-required="true"/>
            <label for="input-income_expense-income" class="col-sm-1 radio-inline">
                Приход
            </label>
            <input
                name="income_expense"
                id="input-income_expense-expense"
                type="radio"
                value="expense"
                required="true"
                {{ (!empty ($incomeExpense->income_expense) && $incomeExpense->income_expense == "expense") ? "checked" : "" }}
                aria-required="true"/>
            <label for="input-income_expense-expense" class="col-sm-1 radio-inline">
                Расход
            </label>
            @if ($errors->has('income_expense'))
                <span id="name-error"
                      class="error text-danger"
                      for="input-income_expense-income">{{ $errors->first('income_expense') }}</span>
            @endif
        </div>
    </div>
</div>


