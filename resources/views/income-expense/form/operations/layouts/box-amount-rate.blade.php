<br>
<div class="row">

    <div class="col-md-4">
        <div class="input-group form-group required">
            <label
                class="col-sm-4 col-lg-4 col-md-4 col-form-label input-group-addon control-label"
                for="select-box_id"
            >Бокс</label>
            <div class="col-sm-8 col-lg-8 col-md-8">
                <select id="select-box_id"
                        name="box_id"
                        required="true"
                        aria-required="true"
                        class="selectpicker"
                        data-style="btn btn-primary btn-round">
                    <option disabled selected></option>
                    @isset($listBox)
                        @foreach($listBox as $box)
                            <option value="{{$box->id}}"
                                    @if(old('box_id') == $box->id)
                                    selected
                                    @elseif(isset($incomeExpense) &&
                                        $incomeExpense->box_id === $box->id
                                        ) selected @endif>
                                {{$box->unique_name}}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mat-form-field-wrapper">
            <label for="input-amount" class="control-label">
                Сумма
            </label>
            <div class="form-group{{ $errors->has('amount_expense') ? ' has-danger' : '' }} required">
                <input
                    class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                    name="amount"
                    id="input-amount"
                    type="number"
                    min="0"
                    step="0.000000000001"
                    required="true"
                    aria-required="true"
                    value="{{ $incomeExpense->amount ?? '' }}">
                @if ($errors->has('amount'))
                    <span id="amount-error" class="error text-danger" for="input-amount">{{ $errors->first('amount') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mat-form-field-wrapper">
            <label for="input-rate" class="control-label">
                Курс
            </label>
            <div class="form-group{{ $errors->has('rate') ? ' has-danger' : '' }} required">
                <input
                    class="form-control"
                    name="rate"
                    id="input-rate"
                    type="number"
                    min="0"
                    step="0.00000001"
                    required="true"
                    aria-required="true"
                    value="{{ $incomeExpense->rate ?? '' }}">
                @if ($errors->has('rate'))
                    <span id="rate-error" class="error text-danger" for="input-rate">{{ $errors->first('rate') }}</span>
                @endif
            </div>
        </div>
    </div>

</div>

