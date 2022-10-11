@include('income-expense.form.operations.layouts.radiobutton-income-expense')

<div class="row">
    <div class="input-group form-group required">
        <label
            class="col-sm-2 col-form-label input-group-addon control-label"
            for="select-partner_id"
        >Партнеры</label>
        <div class="col-sm-10">
            <select id="select-partner_id"
                    name="partner_id"
                    required="required"
                    class="selectpicker"
                    data-style="btn btn-primary btn-round">
                <option disabled selected></option>
                @isset($listPartner)
                    @foreach($listPartner as $partner)
                        <option value="{{$partner->id}}"
                                @if(old('partner_id') == $partner->id)
                                selected
                                @elseif(isset($incomeExpense) &&
                                    $incomeExpense->partner_id === $partner->id
                                    ) selected @endif>
                            {{ $partner->descr }}
                        </option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
</div>

@include('income-expense.form.operations.layouts.box-amount-rate')
