@extends('layouts.app', ['activePage' => 'partners', 'titlePage' => 'Партнеры'])

@push('js')
    <script src="{{ asset('js/books/partners/partners-list.js') }}?v=@version" defer></script>
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Партнеры</h4>
                            <div class="card-actions ml-auto mr-auto">
                                <a href="{{route('partners.create')}}"
                                   class="btn btn-primary"
                                   role="button">Добавить</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table data-table">
                                    <thead class="text-primary">
                                    <th></th>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Кто добавил</th>
                                    <th>Кто изменил</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'partners'])
    </div>

@endsection
