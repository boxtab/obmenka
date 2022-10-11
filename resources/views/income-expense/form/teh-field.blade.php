<br>
<div class="row">

    <div class="col-md-3">
        <div class="mat-form-field-wrapper">
            <label for="input-created_at">
                Дата создания
            </label>
            <input
                class="form-control"
                name="created_at"
                id="input-created_at"
                type="text"
                readonly
                value="{{ $incomeExpense->created_at ?? '' }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="mat-form-field-wrapper">
            <label for="input-created_user_full_name">
                Кто создал запись
            </label>
            <input
                class="form-control"
                name="created_user_full_name"
                id="input-created_user_full_name"
                type="text"
                readonly
                value="{{ $incomeExpense->created_full_name ?? '' }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="mat-form-field-wrapper">
            <label for="input-updated_at">
                Дата редактирования
            </label>
            <input
                class="form-control"
                name="updated_at"
                id="input-updated_at"
                type="datetime-local"
                value="{{$incomeExpense->updated_at ?? ''}}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="mat-form-field-wrapper">
            <label for="input-updated_user_full_name">
                Кто изменил запись
            </label>
            <input
                class="form-control"
                name="updated_user_full_name"
                id="input-updated_user_full_name"
                type="text"
                readonly
                value="{{ $incomeExpense->created_full_name ?? '' }}">
        </div>
    </div>

</div>
