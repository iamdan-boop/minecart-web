@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Items (Claimed)
                                </div>
                                <div class="h-5 mb-0 font-weight-bold text-gray-800">{{ $itemsClaimedCost }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-4 my-lg-0 my-2">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Cashout
                                    (Received)
                                </div>
                                <div
                                    class="h-5 mb-0 font-weight-bold text-gray-800">{{ number_format($receivedCashouts, 2) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-wallet fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 my-lg-0 my-2">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">My Balance
                                </div>
                                <div
                                    class="h-5 mb-0 font-weight-bold text-gray-800">{{ number_format(auth()->user()->balance, 2) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div>
            <div class="card shadow mt-4">
                <div class="card-header py-3">Announcements</div>
                <div class="card-body">
                    @foreach ($announcements as $announcement)
                        <div class="card mt-2">
                            <div class="card-header">{{ $announcement->title }}</div>
                            <div class="card-body">
{{--                                <blockquote class="blockquote mb-0 px-2 px-lg-0 w-auto">--}}
{{--                                   --}}
{{--                                </blockquote>--}}
                                <p class="card-text">{!! $announcement->body !!}</p>
                            </div>
                        </div>
                    @endforeach

                    @if ( $announcements->links()->paginator->hasPages())
                        <div class="mt-4 p-4 d-flex justify-content-end align-items-end">
                            {{ $announcements->onEachSide(2)->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
