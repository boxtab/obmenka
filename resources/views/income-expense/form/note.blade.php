<div class="row">
    <label class="col-sm-2 col-form-label @if ( $isCommentRequired === true ) control-label @endif">Комментарий</label>
    <div class="col-sm-10">
        <div class="form-group{{ $errors->has('note') ? ' has-danger' : '' }} @if ( $isCommentRequired === true ) required @endif">
            <input
                class="form-control{{ $errors->has('note') ? ' is-invalid' : '' }}"
                name="note"
                id="input-note"
                type="text"
                maxlength="1024"
                @if ( $isCommentRequired === true ) required="required" @endif
                value="{{ $incomeExpense->note ?? '' }}">
                @if ($errors->has('note'))
                    <span id="name-error" class="error text-danger" for="input-note">{{ $errors->first('note') }}</span>
                @endif
        </div>
    </div>
</div>
