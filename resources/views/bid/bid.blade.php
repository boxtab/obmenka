<div class="col-md-12">
    <form method="post" action="{{ route('bid.store') }}" autocomplete="off" id="form-bid" class="form-horizontal">
        @csrf
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title">Заявка ID: <span id="bid-id">{{ $bid->id ?? '' }}</span></h4>

                <div class="card-actions ml-auto mr-auto">
                    <a href="{{ route('bid.index') }}" class="btn" role="button">Назад</a>
                    <button class="btn btn-dark"
                            type="button"
                            data-toggle="collapse"
                            data-target="#additional_info"
                            aria-expanded="false"
                            aria-controls="additional_info">
                        Доп. инфо
                    </button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>

                <input type="hidden" name="id" value="{{ $bid->id ?? '' }}">
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-xl-4">
                        <div class="row">
                            <div class="input-group form-group required">
                                <label class="col-sm-4 col-form-label input-group-addon"
                                       for="select-top_destinations_id">Источник дохода</label>
                                <div class="col-sm-8">
                                    <select class="selectpicker"
                                            name="top_destinations_id"
                                            id="select-top_destinations_id"
                                            required
                                            data-style="btn btn-primary btn-round">
                                        <option value="0"
                                                @if( !isset($bid) || !$bid->top_destinations_id) selected @endif>
                                            Выберите из списка
                                        </option>
                                        @foreach($listTopDestinations as $topDestinations)
                                            <option value="{{$topDestinations->id}}"
                                                    @if(isset($bid) && $bid->top_destinations_id === $topDestinations->id  )
                                                    selected
                                                @endif>
                                                {{ $topDestinations->descr }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="number" class="form-control" placeholder="# заявки"
                                           name="bid_number" value="{{ $bid->bid_number ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input class="form-control" name="note" type="text"
                                           placeholder="Комментарий" value="{{ $bid->note ?? '' }}"/>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="collapse" id="additional_info">

                    <div class="row">
                        <label class="col-md-2 col-form-label">Менеджер</label>
                        <div class="col-md-2">
                            <select name="manager_user_id" class="selectpicker" data-width="100%"
                                    data-style="btn btn-primary btn-round">
                                <option value="0"
                                        @if( !isset($bid) || !$bid->manager_user_id) selected @endif>
                                    Выберите из списка
                                </option>
                                @foreach($listUser as $user)
                                    <option value="{{$user->id}}"
                                            @if(isset($bid) && $bid->manager_user_id == $user->id  )
                                            selected
                                        @endif>
                                        {{ $user->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label class="col-md-2 col-form-label">Дата редактирования</label>
                        <label class="col-md-2 col-form-label" id="label-updated_at">{{$bid->updated_at ?? ''}}</label>
                        <div class="col-md-4">
                            <button id="updated_paste" type="button" class="btn btn-default">Перенести</button>
                            <input id="input-updated_at" type="datetime-local" name="updated_at" value="">
                            <button id="updated_clear" type="button" class="btn btn-default">Очистить</button>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-2 col-form-label">Клиент</label>
                        <div class="col-md-8">
                            <select name="client_id" class="selectpicker" data-width="100%"
                                    data-style="btn btn-primary btn-round">
                                <option value="0"
                                        @if( !isset($bid) || !$bid->client_id) selected @endif>
                                    Выберите из списка
                                </option>
                                @foreach($listClient as $client)
                                    <option value="{{$client->id}}"
                                            @if(isset($bid) && $bid->client_id === $client->id  )
                                            selected
                                        @endif>
                                        {{ $client->full_info }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-xl-1 mt-3 mt-md-0">
                            @if(isset($bid) && $bid->client_id)
                                <a href="{{ route('client.edit', ['client' => $bid->client_id]) }}" target="_blank"
                                   class="btn btn-primary w-100">Ред.</a>
                            @endif
                        </div>

                        <div class="col-6 col-xl-1 mt-3 mt-md-0">
                            <a href="{{ route('client.create') }}" target="_blank" class="btn btn-primary w-100">Добавить</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </form>
</div>
