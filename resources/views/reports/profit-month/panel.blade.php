<form method="POST"
      action="{{ route('reports.profit-month.index') }}"
      autocomplete="off"
      id="form-filter">
    @csrf
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group{{ $errors->has('filter_month') ? ' has-danger' : '' }}">
                <input
                    class="form-control{{ $errors->has('filter_month') ? ' is-invalid' : '' }}"
                    name="filter_month"
                    id="input-filter_month"
                    type="month"
                    value="{{ session('report_profit_month_filter_month', null) }}"
                />
                @if ($errors->has('filter_month'))
                <span id="name-error" class="error text-danger" for="input-filter_month">{{ $errors->first('filter_month') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-10 text-left">
            <button type="submit" form="form-filter" class="btn btn-success">Фильтр</button>
        </div>
    </div>
</form>
