<form method="POST"
      action="{{ route('bid.index') }}"
      autocomplete="off"
      id="form-bid-filter">
    @csrf
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group">
                <label for="input-start_date">Дата С:</label>
                <input
                    class="form-control"
                    name="start_date"
                    id="input-start_date"
                    type="date"
                    value="{{ session('bid_filter_start_date', null) }}"
                />
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="input-stop_date">Дата По:</label>
                <input
                    class="form-control"
                    name="stop_date"
                    id="input-stop_date"
                    type="date"
                    value="{{ session('bid_filter_stop_date', null) }}"
                />
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group">
                <label for="select-direction_get_id">Получаем</label>
                <select id="select-direction_get_id" name="direction_get_id"
                        class="selectpicker" data-style="btn btn-primary btn-round">
                    <option selected>Выберите из списка</option>
                    @isset($listDirectionGet)
                        @foreach($listDirectionGet as $directionGet)
                            <option value="{{$directionGet->id}}"
                                    @if(session('bid_filter_direction_get_id') == $directionGet->id )
                                    selected @endif>
                                {{$directionGet->paymentSystem->descr}} {{$directionGet->currency->descr}}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group">
                <label for="select-direction_give_id">Отдаем</label>
                <select id="select-direction_give_id" name="direction_give_id"
                        class="selectpicker" data-style="btn btn-primary btn-round">
                    <option selected>Выберите из списка</option>
                    @isset($listDirectionGive)
                        @foreach($listDirectionGive as $directionGive)
                            <option value="{{$directionGive->id}}"
                                    @if(session('bid_filter_direction_give_id') == $directionGive->id )
                                    selected @endif>
                                {{$directionGive->paymentSystem->descr}} {{$directionGive->currency->descr}}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="input-bid_number"># Заявки:</label>
                <input
                    class="form-control"
                    name="bid_number"
                    id="input-bid_number"
                    type="number"
                    min="0"
                    step="1"
                    value="{{ session('bid_filter_bid_number', null) }}"
                />
            </div>
        </div>
        <div class="col-sm-2">
            <a href="{{route('bid.reset-filter')}}"
               class="btn btn-primary"
               role="button">Очистить</a>
            <button type="submit" form="form-bid-filter" value="Фильтр" class="btn btn-primary">Фильтр</button>
        </div>
    </div>
</form>
