<form method="POST"
      action="{{ route('income-expense.index') }}"
      autocomplete="off"
      id="form-income-expense-filter">
    @csrf
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group">
                <label for="input-start_date">Дата С:</label>
                <input
                    class="form-control"
                    name="start_date"
                    id="input-start_date"
                    type="date"
                    value="{{ session('income-expense_filter_start_date', null) }}"
                />
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="input-stop_date">Дата По:</label>
                <input
                    class="form-control"
                    name="stop_date"
                    id="input-stop_date"
                    type="date"
                    value="{{ session('income-expense_filter_stop_date', null) }}"
                />
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group">
                <label for="select-income_expense">Приход/Расход</label>
                <select id="select-income_expense" name="income_expense"
                        class="selectpicker" data-style="btn btn-primary btn-round">
                    <option value="" selected>Выберите из списка</option>
                    <option @if( session('income-expense_filter_income_expense') === 'income' ) selected @endif value="income">Приход</option>
                    <option @if( session('income-expense_filter_income_expense') === 'expense' ) selected @endif value="expense">Расход</option>
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group">
                <label for="select-dds_id">Код ДДС</label>
                <select id="select-dds_id" name="dds_id"
                        class="selectpicker" data-style="btn btn-primary btn-round">
                    <option value="" selected>Выберите из списка</option>
                    @isset($listDDS)
                        @foreach($listDDS as $dds)
                            <option value="{{$dds->id}}"
                                    @if(session('income-expense_filter_dds_id') == $dds->id  )
                                    selected @endif>
                                {{$dds->descr}}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group">
                <label for="select-box_id">Бокс</label>
                <select id="select-box_id" name="box_id"
                        class="selectpicker" data-style="btn btn-primary btn-round">
                    <option value="" selected>Выберите из списка</option>
                    @isset($listBox)
                        @foreach($listBox as $box)
                            <option value="{{$box->id}}"
                                    @if(session('income-expense_filter_box_id') == $box->id  )
                                    selected @endif>
                                {{$box->unique_name}}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <a href="{{route('income-expense.reset-filter')}}"
               class="btn btn-primary"
               role="button">Очистить</a>
            <button type="submit" form="form-income-expense-filter" value="Фильтр" class="btn btn-primary">Фильтр</button>
        </div>
    </div>
</form>
