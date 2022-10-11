@include('income-expense.form.operations.layouts.radiobutton-income-expense')

<div class="row">
    <div class="input-group form-group required">
        <label
            class="col-sm-2 col-form-label input-group-addon control-label"
            for="select-dds_id"
        >ДДС</label>
        <div class="col-sm-10">
            <select id="select-dds_id"
                    name="dds_id"
                    required="required"
                    aria-required="true"
                    class="selectpicker"
                    data-style="btn btn-primary btn-round">
                <option disabled selected></option>
                @isset($listDDS)
                    @foreach($listDDS as $dds)
                        <option value="{{$dds->id}}"
                                @if(old('partners_id') == $dds->id)
                                selected
                                @elseif(isset($incomeExpense) &&
                                    $incomeExpense->dds_id === $dds->id
                                    ) selected @endif>
                            {{ $dds->descr }}
                        </option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
</div>

@include('income-expense.form.operations.layouts.box-amount-rate')
