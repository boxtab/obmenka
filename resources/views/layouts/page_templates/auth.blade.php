<div class="wrapper">
    @include('layouts.navbars.sidebar')
    <div class="main-panel">
        @include('layouts.messages.success')
        @include('layouts.messages.success-js')
        @include('layouts.messages.errors')
        @include('layouts.messages.errors-js')
        @include('layouts.navbars.navs.auth')
        @yield('content')
        @include('layouts.footers.auth')
    </div>
</div>
