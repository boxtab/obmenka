<div class="row">
    <label class="col-sm-2 col-form-label">Кто создал запись</label>
    <div class="col-sm-7">
        <div class="form-group">
            <input
                class="form-control"
                name="created_user_full_name"
                id="input-created_user_full_name"
                type="text"
                readonly
                @isset($boxBalance)
                    value="{{$boxBalance->createdUser['surname'] . ' '
                    . mb_substr($boxBalance->createdUser['name'], 0, 1) . '. '
                    . mb_substr($boxBalance->createdUser['patronymic'], 0, 1) . '.'}}"
                @else
                    value=""
                @endisset >
        </div>
    </div>
</div>
<div class="row">
    <label class="col-sm-2 col-form-label">Кто изменил запись</label>
    <div class="col-sm-7">
        <div class="form-group">
            <input
                class="form-control"
                name="updated_user_full_name"
                id="input-updated_user_full_name"
                type="text"
                readonly
                @isset($boxBalance)
                    value="{{$boxBalance->createdUser['surname'] . ' '
                    . mb_substr($boxBalance->createdUser['name'], 0, 1) . '. '
                    . mb_substr($boxBalance->createdUser['patronymic'], 0, 1) . '.'}}"
                @else
                    value=""
                @endisset>
        </div>
    </div>
</div>
<div class="row">
    <label class="col-sm-2 col-form-label">Дата создания</label>
    <div class="col-sm-7">
        <div class="form-group">
            <input
                class="form-control"
                name="created_at"
                id="input-created_at"
                type="text"
                readonly
                value="{{$boxBalance->created_at ?? ''}}"/>
        </div>
    </div>
</div>
<div class="row">
    <label class="col-sm-2 col-form-label">Дата редактирования</label>
    <div class="col-sm-7">
        <div class="form-group">
            <input
                class="form-control"
                name="updated_at"
                id="input-updated_at"
                type="text"
                readonly
                value="{{$boxBalance->updated_at ?? ''}}"/>
        </div>
    </div>
</div>
