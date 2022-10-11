@extends('layouts.app', ['activePage' => 'bid', 'titlePage' => 'Заявка: Добавление/Редактирование'])

@push('js')
    <script src="{{ asset('js/bid/add-delete-offer.js') }}?v=@version" defer></script>
    <script src="{{ asset('js/bid/updated_at-change.js') }}?v=@version" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @include('bid.bid')
            </div>
            <div class="row">
                @include('bid.offer')
            </div>
        </div>
        @include('layouts.modal.delete-confirm', ['baseUrlDelete' => 'offer/destroy'])
    </div>
@endsection

@section('summary-line')
    @include('summary-line')
@endsection
