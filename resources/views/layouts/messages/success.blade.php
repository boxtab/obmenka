@if(session()->has('success'))
    <div class="alert alert-success">
        <ul>
            @foreach (session()->get('success') as $success)
                <li>{{ $success }}</li>
            @endforeach
        </ul>
    </div>
@endif
