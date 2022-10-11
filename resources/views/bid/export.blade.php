@extends('layouts.app', ['activePage' => 'bid', 'titlePage' => 'Экспорт'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Экспорт</h4>
                        </div>
                        <div class="card-body">

                            <form method="GET" action="{{ route('bid.export') }}" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="input-start_date">Дата С:</label>
                                            <input class="form-control" name="start_date" id="input-start_date"
                                                   type="date" value="{{ request()->input('start_date') }}"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="input-stop_date">Дата По:</label>
                                            <input class="form-control" name="stop_date" id="input-stop_date"
                                                   type="date" value="{{ request()->input('stop_date') }}"/>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <label for="select-delimiter">Разделитель</label>
                                            <select id="select-delimiter" name="delimiter" class="selectpicker"
                                                    data-style="btn btn-primary btn-round">
                                                <option value="tab"
                                                        @if( !request()->input('delimiter') || request()->input('delimiter') == 'tab') selected @endif>
                                                    Табуляция
                                                </option>
                                                <option value="coma"
                                                        @if( request()->input('delimiter') == 'coma' ) selected @endif>
                                                    Запятая
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <a class="btn btn-primary"
                                           href="{{ route('bid.export') }}">Сбросить</a>
                                        <button type="submit" class="btn btn-primary" name="export">Экспорт</button>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="input-template">Шаблон вывода:</label>
                                            <input class="form-control" name="template" id="input-template" type="text"
                                                   value="{{ request()->input('template', '{BID_NUMBER}||||{TD}|{INC_DATE}|{INC_BOX}|{INC_AMOUNT}|{EXC_DATE}|{EXC_BOX}|{EXC_AMOUNT}') }}"/>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <hr/>
                            <p>
                                <button class="btn btn-primary" type="button" data-toggle="collapse"
                                        data-target="#collapseExample" aria-expanded="false"
                                        aria-controls="collapseExample">
                                    Помощь
                                </button>
                            </p>
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body m-0">
                                    <div>Шаблон вывода нужен для понимания программе, в каком виде нужно делать
                                        экспорт.<br/>Благодаря специальным кодам, программа вместо них подставляет
                                        определенные значения.
                                    </div>
                                    <br/>
                                    <div><b>|</b> - требуется для подстановки разделителя</div>
                                    <div><b>{}</b> - каждый спец. код должен быть в фигурных скобках</div>
                                    <div>Помимо кодов, можно вписывать произвольные значения, которые будут в каждой
                                        строке, например: {DATE}|мой текст
                                    </div>

                                    <div><b>BID_NUMBER</b> - Номер заявки</div>
                                    <div><b>TD</b> - Источник доходов</div>
                                    <div><b>INC_DATE</b> - Дата платежа "Приход" в формате ДД.ММ.ГГГГ</div>
                                    <div><b>INC_BOX</b> - Полный номер счета "Приход" (или последние 4 цифры карты)</div>
                                    <div><b>INC_AMOUNT</b> - Сумма "Приход"</div>
                                    <div><b>EXC_DATE</b> - Дата платежа "Расход" в формате ДД.ММ.ГГГГ</div>
                                    <div><b>EXC_BOX</b> - Полный номер счета "Расход" (или последние 4 цифры карты)</div>
                                    <div><b>EXC_AMOUNT</b> - Сумма "Расход"</div>
                                </div>
                            </div>
                            <hr/>

                            <textarea class="form-control" rows="25" style="border: 1px solid #000;" wrap="off"
                                      readonly>
@isset( $listFormatted ){{ $listFormatted }}@endisset
</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
