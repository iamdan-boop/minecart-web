@extends('layouts.dashboard')


@push('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endpush


@section('dashboard-content')
    <div>
        <div class="container">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="mr-5 font-weight-bold text-primary">Income Log of Users</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="claimIndexTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Total Claimed Item Income</th>
                                <th>Total Claimed Cashout</th>
                                <th>Total Money</th>
                                <th>Current Money</th>
                                <th>Difference</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($userWithItems as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->total_item_claimed_income ?? 0 }}</td>
                                    <td>{{ $user->total_cashout_claimed ?? 0 }}</td>
                                    <td>{{ $user->total_money ?? 0 }}</td>
                                    <td>{{ $user->balance }}</td>
                                    <td>{{ ($user->total_money - $user->balance) < 0 ? 0 : number_format($user->total_money - $user->balance, 2) }}</td>
                                    <td>
                                        <form action="{{ route('transaction.reset-wallet', $user) }}" method="POST"
                                              onsubmit="return confirm('Reset this wallet?')">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-danger" type="submit">Reset Wallet</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ( $userWithItems->links()->paginator->hasPages())
                        <div class="mt-4 p-4 d-flex justify-content-end align-items-end">
                            {{ $userWithItems->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('#claimIndexTable').DataTable({
                paging: false
            });
        })
    </script>
@endpush
