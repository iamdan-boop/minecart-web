<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #474f52" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="{{ route('dashboard.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="{{ asset('img/undraw_rocket.svg') }}" style="height: 30px;" alt="">
        </div>
        <div class="sidebar-brand-text mx-3">Minecart Shop</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">


    @if(auth()->user()->isAdmin())
        <li class="nav-item {{ Route::is('dashboard.index') ? 'active' : '' }}">
            <a class="nav-link"
               href="{{ route('dashboard.index') }}">
                <i class="fa-solid fa-home"></i>
                <span>{{ __('Dashboard') }}</span>
            </a>
        </li>

        <li class="nav-item {{ Route::is('announcements.index') ? 'active' : '' }}">
            <a class="nav-link"
               href="{{ route('announcements.index') }}">
                <i class="fas fa-bullhorn"></i>
                <span>{{ __('Announcements') }}</span></a>
        </li>
    @else

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ Route::is('customer.dashboard.index') ? 'active' : '' }}">
            <a class="nav-link"
               href="{{ route('customer.dashboard.index') }}">
                <i class="fas fa-home"></i>
                <span>{{ __('Dashboard') }}</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">


        <div class="sidebar-heading">Items</div>

        <!-- Nav Item - Clients -->
        <li class="nav-item {{ Route::is('customer.items.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('customer.items.index') }}">
                <i class="fa-solid fa-shopping-cart"></i>
                <span>{{ __('My Items') }}</span>
            </a>
        </li>




        <div class="sidebar-heading">Transactions</div>
        <!-- Nav Item - Clients -->
        <li class="nav-item {{ Route::is('customer.cashouts.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('customer.cashouts.index') }}">
                <i class="fa-solid fa-wallet"></i>
                <span>{{ __('Cashouts') }}</span>
            </a>
        </li>



        {{--        <!-- Nav Item - Client Bills -->--}}
        {{--        <li class="nav-item {{ Route::is('treatment-area.index') ? 'active' : '' }}">--}}
        {{--            <a class="nav-link" href="{{ route('treatment-area.index') }}">--}}
        {{--                <i class="fa-solid fa-hospital"></i>--}}
        {{--                <span>{{ __('Treatment Areas') }}</span>--}}
        {{--            </a>--}}
        {{--        </li>--}}


        {{--        <li class="nav-item {{ Route::is('treatment-modality.index') ? 'active' : '' }}">--}}
        {{--            <a class="nav-link" href="{{ route('treatment-modality.index') }}">--}}
        {{--                <i class="fa-solid fa-heart-circle-plus"></i>--}}
        {{--                <span>{{ __('Treatment Modalities') }}</span>--}}
        {{--            </a>--}}
        {{--        </li>--}}


        {{--        <li class="nav-item {{ Route::is('department.index') ? 'active' : '' }}">--}}
        {{--            <a class="nav-link" href="{{ route('department.index') }}">--}}
        {{--                <i class="fa-solid fa-building"></i>--}}
        {{--                <span>{{ __('Departments') }}</span>--}}
        {{--            </a>--}}
        {{--        </li>--}}


        {{--        <li class="nav-item {{ Route::is('funding.index') ? 'active' : '' }}">--}}
        {{--            <a class="nav-link" href="{{ route('funding.index') }}">--}}
        {{--                <i class="fa-solid fa-building-columns"></i>--}}
        {{--                <span>{{ __('Fundings') }}</span>--}}
        {{--            </a>--}}
        {{--        </li>--}}

        {{--        <!-- Divider -->--}}
        {{--        <hr class="sidebar-divider d-none d-md-block">--}}
    @endif


    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-3">
        {{-- <button class="rounded-circle border-0 mt-5" id="sidebarToggle"></button> --}}
    </div>

</ul>
