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
                    <h6 class="mr-5 font-weight-bold text-primary ">Cashout Logs</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="claimIndexTable">
                            <thead>
                            <tr>
                                <th>Request Date</th>
                                    <th>Approved Date</th>
                                <th>Released Date</th>
                                <th>Receiver Name</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($cashouts as $cashout)
                                <tr>
                                    <td>{{ $cashout->request_date }}</td>
                                    <td>{{ $cashout->approved_date }}</td>
                                    <td>{{ $cashout->release_date }}</td>
                                    <td>{{ $cashout->owner->name }}</td>
                                    <td>{{ $cashout->amount }}</td>
                                    <td>
                                        <form action="{{ route('cashouts.approved.claim', $cashout) }}" method="POST"
                                              onsubmit="return confirm('Approve Claim cashout?')">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-success" type="submit">Cashout Claimed</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ( $cashouts->links()->paginator->hasPages())
                        <div class="mt-4 p-4 d-flex justify-content-end align-items-end">
                            {{ $cashouts->links() }}
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
