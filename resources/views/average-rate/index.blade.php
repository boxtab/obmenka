@extends('layouts.app', ['activePage' => 'average-rate', 'titlePage' => 'Средние курсы'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Средние курсы</h4>
                            <div class="card-actions ml-auto mr-auto">
                                <button
                                    type="button"
                                    class="btn btn-default"
                                    rel="tooltip"
                                    data-toggle="modal"
                                    data-target="#buildModal">
                                    Сформировать
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-default"
                                    rel="tooltip"
                                    data-toggle="modal"
                                    data-target="#clearModal">
                                    Очистить
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>Валлюта</th>
                                        @isset( $listLastDays )
                                            @foreach( $listLastDays as $lastDays )
                                                <th>{{ $lastDays  }}</th>
                                            @endforeach
                                        @endisset
                                    </thead>
                                    <tbody>
                                        @isset( $pivotAverageRate )
                                            @foreach( $pivotAverageRate as $averageRate )
                                                <tr>
                                                    <td>{{ $averageRate->currency_descr }}</td>
                                                    @foreach( $fieldNameLastDays as $fieldName)
                                                        <td>{{ $averageRate->$fieldName }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('average-rate.modal-clear')
        @include('average-rate.modal-build')
    </div>
@endsection
