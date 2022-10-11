<form method="POST"
      action="{{ route('reports.profit-day.index') }}"
      autocomplete="off"
      id="form-filter">
    @csrf
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group{{ $errors->has('filter_date') ? ' has-danger' : '' }}">
                <input
                    class="form-control{{ $errors->has('filter_date') ? ' is-invalid' : '' }}"
                    name="filter_date"
                    id="input-filter_date"
                    type="date"
                    value="{{ session('report_profit_day_filter_date', null) }}"
                />
                @if ($errors->has('filter_date'))
                    <span id="name-error" class="error text-danger" for="input-filter_date">{{ $errors->first('filter_date') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-10 text-left">
            <button type="submit" form="form-filter" class="btn btn-primary">Фильтр</button>
        </div>
    </div>
</form>
