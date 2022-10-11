<form method="POST"
      action="{{ route('reports.profit-direction.index') }}"
      autocomplete="off"
      id="form-filter">
    @csrf
    <div class="row">

        <div class="col-sm-2">
            <div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }}">
                <input
                    class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}"
                    name="start_date"
                    id="input-start_date"
                    type="date"
                    value="{{session('report_profit_direction_start_date', null)}}"
                />
                @if ($errors->has('start_date'))
                    <span id="name-error" class="error text-danger" for="input-start_date">{{ $errors->first('start_date') }}</span>
                @endif
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group{{ $errors->has('end_date') ? ' has-danger' : '' }}">
                <input
                    class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}"
                    name="end_date"
                    id="input-end_date"
                    type="date"
                    value="{{session('report_profit_direction_end_date', null)}}"
                />
                @if ($errors->has('end_date'))
                    <span id="name-error" class="error text-danger" for="input-end_date">{{ $errors->first('end_date') }}</span>
                @endif
            </div>
        </div>

        <div class="col-sm-8 text-left">
            <button type="submit" form="form-filter" class="btn btn-primary">Фильтр</button>
        </div>
    </div>
</form>
