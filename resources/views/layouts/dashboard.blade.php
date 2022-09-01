@extends('layouts.auth')



@section('main-content')

    <div id="wrapper">
        <!-- Sidebar -->
        @include('includes.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                @include('includes.topbar')
                <!-- End of Topbar -->
                @yield('dashboard-content')
                <x:notify-messages/>
            </div>
        </div>
    </div>
@endsection
