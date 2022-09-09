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
                    <h6 class="mr-5 font-weight-bold text-primary">Cashout Logs</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="announcementTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Request Date</th>
                                <th>Receiver Name</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($cashouts as $cashout)
                                <tr>
                                    <td>{{ $cashout->request_date }}</td>
                                    <td>{{ $cashout->name }}</td>
                                    <td>{{ $cashout->amount }}</td>
                                    <td>
                                        <div class="container">
                                            <div class="row justify-content-center lg:justify-start">
                                                <button class="btn btn-success mb-2 mr-2 lg:mb-0 acceptCashoutBtn"
                                                        data-toggle="modal"
                                                        data-target="#cashoutRequestModal"
                                                        data-object="{{ json_encode($cashout) }}">Accept
                                                </button>
                                                <form action="{{ route('cashouts.decline', $cashout) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-danger" type="submit">Decline</button>
                                                </form>
                                            </div>
                                        </div>
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


    {{--  Create Item  --}}
    <div class="modal fade" id="cashoutRequestModal" tabindex="-1" role="dialog"
         aria-labelledby="cashoutRequestModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" id="cashoutForm" onsubmit="return confirm('Approve this cashout?')">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cashout Approval Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group d-flex align-items-center justify-content-center">
                            <h5 class="h5">Request Date : <b id="request_date"></b></h5>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-center">
                            <h5 class="h5">Amount Requesting : <b id="request_amount"></b></h5>
                        </div>

                        <div class="form-group">
                            <label for="release_date">Date to Released</label>
                            <input id="release_date" class="form-control form-control-user" type="text"
                                   name="release_date"
                                   placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </div>
            </form>
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
            $('#announcementTable').DataTable({
                paging: false
            });

            $('.acceptCashoutBtn').click(function () {
                const cashout = $(this).data('object')
                console.log(cashout)
                $('#request_date').text(cashout.request_date)
                $('#request_amount').text(cashout.amount)
                $('#cashoutForm').attr('action', "/admin/cashouts/" + cashout.id + '/approve')
            })

            $('#release_date').datetimepicker()
        })
    </script>
@endpush
