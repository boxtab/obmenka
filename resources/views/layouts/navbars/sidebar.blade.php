<div class="sidebar" data-color="green" data-background-color="white"
     data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
    <div class="logo d-none">
        <a href="{{ route('home') }}" class="simple-text logo-normal">
            {{config('app.name')}}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Главная</p>
                </a>
            </li>





{{--            <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">--}}
{{--                <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">--}}
{{--                    <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>--}}
{{--                    <p>{{ __('Laravel Examples') }}--}}
{{--                        <b class="caret"></b>--}}
{{--                    </p>--}}
{{--                </a>--}}
{{--                <div class="collapse show" id="laravelExample">--}}
{{--                    <ul class="nav">--}}
{{--                        <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">--}}
{{--                            <a class="nav-link" href="{{ route('profile.edit') }}">--}}
{{--                                <span class="sidebar-mini"> UP </span>--}}
{{--                                <span class="sidebar-normal">{{ __('User profile') }} </span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">--}}
{{--                            <a class="nav-link" href="{{ route('user.index') }}">--}}
{{--                                <span class="sidebar-mini"> UM </span>--}}
{{--                                <span class="sidebar-normal"> {{ __('User Management') }} </span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}
{{--            <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">--}}
{{--                <a class="nav-link" href="{{ route('table') }}">--}}
{{--                    <i class="material-icons">content_paste</i>--}}
{{--                    <p>{{ __('Table List') }}</p>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">--}}
{{--                <a class="nav-link" href="{{ route('typography') }}">--}}
{{--                    <i class="material-icons">library_books</i>--}}
{{--                    <p>{{ __('Typography') }}</p>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">--}}
{{--                <a class="nav-link" href="{{ route('icons') }}">--}}
{{--                    <i class="material-icons">bubble_chart</i>--}}
{{--                    <p>{{ __('Icons') }}</p>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">--}}
{{--                <a class="nav-link" href="{{ route('map') }}">--}}
{{--                    <i class="material-icons">location_ons</i>--}}
{{--                    <p>{{ __('Maps') }}</p>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">--}}
{{--                <a class="nav-link" href="{{ route('notifications') }}">--}}
{{--                    <i class="material-icons">notifications</i>--}}
{{--                    <p>{{ __('Notifications') }}</p>--}}
{{--                </a>--}}
{{--            </li>--}}





            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'currency' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('currency.index') }}">
                        <i class="material-icons">language</i>
                        <p>Коды валют</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'payment-system' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('payment-system.index') }}">
                        <i class="material-icons">card_giftcard</i>
                        <p>Платежные системы</p>
                    </a>
                </li>
            @endcan


            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'direction' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('direction.index') }}">
                        <i class="material-icons">language</i>
                        <p>Направление</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'box' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('box.index') }}">
                        <i class="material-icons">account_balance_wallet</i>
                        <p>Счета</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'partners' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('partners.index') }}">
                        <i class="material-icons">android</i>
                        <p>Партнеры</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'dds' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('dds.index') }}">
                        <i class="material-icons">library_books</i>
                        <p>ДДС</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'top-destinations' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('top-destinations.index') }}">
                        <i class="material-icons">all_out</i>
                        <p>Источники дохода</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'top-destinations-group' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('top-destinations-group.index') }}">
                        <i class="material-icons">all_inbox</i>
                        <p>Группы источников дохода</p>
                    </a>
                </li>
            @endcan


        @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'income-expense' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('income-expense.index') }}">
                        <i class="material-icons">cached</i>
                        <p>Приход/Расход</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist/manager')
                <li class="nav-item{{ $activePage == 'bid' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('bid.index') }}">
                        <i class="material-icons">content_paste</i>
                        <p>Заявки</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'average-rate' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('average-rate.index') }}">
                        <i class="material-icons">euro_symbol</i>
                        <p>Средние курсы</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin')
                <li class="nav-item{{ $activePage == 'role' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('role.index') }}">
                        <i class="material-icons">accessibility</i>
                        <p>Роли</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin')
                <li class="nav-item{{ $activePage == 'user' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('user.index') }}">
                        <i class="material-icons">account_box</i>
                        <p>Пользователи</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist/manager')
                <li class="nav-item{{ $activePage == 'box-balance' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('box-balance.index') }}">
                        <i class="material-icons">euro_symbol</i>
                        <p>Остатки</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'initial-rate' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('initial-rate.index') }}">
                        <i class="material-icons">paid</i>
                        <p>Остатки по валютам</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'initial-box' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('initial-box.index') }}">
                        <i class="material-icons">dynamic_feed</i>
                        <p>Остатки по счетам</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist/manager')
                <li class="nav-item{{ $activePage == 'client' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('client.index') }}">
                        <i class="material-icons">contacts</i>
                        <p>Клиенты</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'reports.profit-day' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('reports.profit-day.index') }}">
                        <i class="material-icons">open_with</i>
                        <p>Доход по каждой операции</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'reports.profit-month' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('reports.profit-month.index') }}">
                        <i class="material-icons">favorite</i>
                        <p>Доход за месяц</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'reports.profit-direction' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('reports.profit-direction.index') }}">
                        <i class="material-icons">savings</i>
                        <p>Доходы по направлению</p>
                    </a>
                </li>
            @endcan

            @can('role', 'admin/economist')
                <li class="nav-item{{ $activePage == 'reports.profit-source' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('reports.profit-source.index') }}">
                        <i class="material-icons">explore</i>
                        <p>Доход по источнику</p>
                    </a>
                </li>
            @endcan

        </ul>
        <div class="version">@version</div>
    </div>
</div>
