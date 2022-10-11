<form method="POST"
      action="{{ route('box-balance.index') }}"
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
                    value="{{ session('box-balance_filter_date', null) }}"
                />
                @if ($errors->has('filter_date'))
                    <span id="name-error" class="error text-danger" for="input-filter_date">{{ $errors->first('filter_date') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-10 text-left">
            <a href="{{route('box-balance.reset-filter')}}"
               class="btn btn-primary"
               role="button"><i class="material-icons">clear</i></a>
            <button type="submit" form="form-filter" class="btn btn-primary">Фильтр</button>
        </div>
    </div>
</form>
<form method="POST"
      action="{{ route('box-balance.duplicate') }}"
      id="form-duplicate">
    <div class="row">
        @csrf
        <div class="col-sm-2">
            <div class="form-group{{ $errors->has('donor_date') ? ' has-danger' : '' }}">
                <input
                    class="form-control{{ $errors->has('donor_date') ? ' is-invalid' : '' }}"
                    name="donor_date"
                    id="input-donor_date"
                    type="date"
                    value=""
                />
                @if ($errors->has('donor_date'))
                    <span id="name-error" class="error text-danger" for="input-donor_date">{{ $errors->first('donor_date') }}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-2">
            <button type="button"
                    class="btn btn-primary"
                    onclick="document.getElementById('input-donor_date').value = '';"
                    ><i class="material-icons">clear</i></button>
            <button type="submit" form="form-duplicate" class="btn btn-primary">Клонировать</button>
        </div>
    </div>
</form>
