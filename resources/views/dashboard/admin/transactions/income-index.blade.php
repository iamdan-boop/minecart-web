@extends('layouts.dashboard')


@push('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endpush

@section('dashboard-content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Over all Received
                                    Sellers Money
                                </div>
                                <div class="h-5 mb-0 font-weight-bold text-gray-800">
                                    PHP {{ number_format($overallReceivedSellersMoney, 2) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1"><span
                                        id="receivedSellersMoneyLabel">Today Received
                                    Sellers Money</span>
                                </div>
                                <div
                                    class="h-5 mb-0 font-weight-bold text-gray-800">
                                    <span
                                        id="receivedSellersMoney">PHP {{  number_format($todayReceivedSellersMoney, 2) }}</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-wallet fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Overall Handling
                                    Fee
                                </div>
                                <div
                                    class="h-5 mb-0 font-weight-bold text-gray-800">
                                    PHP {{ number_format($overallHandlingFee, 2) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    <span id="overallHandlingFeeLabel">Today Received Handling Fee</span>
                                </div>
                                <div
                                    class="h-5 mb-0 font-weight-bold text-gray-800 ">
                                    <span id="overallHandlingFee">PHP {{ $overallHandlingFeeToday }}</span></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-3 mt-2">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Overall User
                                    Wallet
                                </div>
                                <div
                                    class="h-5 mb-0 font-weight-bold text-gray-800">
                                    PHP {{ number_format($overallUserWalletBalance, 2) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card shadow mb-4 mt-3">
            <div class="card-header py-3">
                <h6 class="mr-5 font-weight-bold text-primary ">Date Range</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <label for="from_date">From Date</label>
                        <input id="from_date" type="text" name="from_date" class="form-control form-control-user"
                               placeholder="From Date"/>
                    </div>
                    <div class="col-6">
                        <label for="to_date">To Date</label>
                        <input id="to_date" type="text" name="to_date" class="form-control form-control-user"
                               placeholder="To Date"/>
                    </div>
                </div>
                <button class="btn btn-primary w-100 mt-2 filterIncomeBtn">Filter</button>
            </div>
        </div>


        @if($users->isNotEmpty())
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="mr-5 font-weight-bold text-primary ">Users</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="transactionTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->wallet->balance }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ( $users->links()->paginator->hasPages())
                        <div class="mt-4 p-4 d-flex justify-content-end align-items-end">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $('#from_date').datetimepicker();
        $('#to_date').datetimepicker();


        $('#transactionTable').DataTable({
            paging: false,
        });
        $('#receivedHandlingFeeTable').DataTable();


        $('.filterIncomeBtn').click(function () {
            $.ajax({
                url: "{{ route('transaction.ajax-filter-log-income') }}",
                data: {
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val(),
                },
                success: data => {
                    console.log(data);
                    $('#receivedSellersMoneyLabel').text(data.from_date + "Received Sellers Money")
                    $('#receivedSellersMoney').text("PHP" + data.todayReceivedSellersMoney)

                    $('#overallHandlingFeeLabel').text(data.from_date + "Received Handling Fee")
                    $('#overallHandlingFee').text("PHP" + data.overallHandlingFee)
                }
            })
        })
    </script>
@endpush
