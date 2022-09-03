@extends('layouts.dashboard')


@push('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush


@section('dashboard-content')

    @if($errors->any())
        @php
            notify()->error(join(',', $errors->all()))
        @endphp
    @endif

    <div>
        <div class="container">
            <div class="card shadow mb-4 ">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h6 class="mr-5 font-weight-bold text-primary ">Cashouts Logs</h6>
                        </div>
                        <button class="btn btn-success col-12 col-lg-3 mt-2 mx-auto mt-lg-0"
                                data-toggle="modal" data-target="#requestCashoutModal">Request Cashout
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="cashoutTable">
                            <thead>
                            <tr>
                                <th>Request Date</th>
                                <th>Release Date</th>
                                <th>Receiver Name</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cashouts as $cashout)
                                <tr>
                                    <td>{{ $cashout->request_date }}</td>
                                    <td>{{ $cashout->release_date }}</td>
                                    <td>{{ $cashout->name }}</td>
                                    <td>{{ $cashout->amount }}</td>
                                    <td>{{ $cashout->status }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($cashouts->links()->paginator->hasPages())
                        <div class="mt-4 p-4 d-flex justify-content-end align-items-end">
                            {{ $cashouts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{--  Create Item  --}}
    <div class="modal fade" id="requestCashoutModal" tabindex="-1" role="dialog"
         aria-labelledby="requestCashoutModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('customer.cashouts.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cashout Request Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="receiver">Name of Receiver</label>
                            <input id="receiver" type="text" class="form-control form-control-user"
                                   name="name"
                                   placeholder="John Doe">
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input id="amount" type="number" class="form-control form-control-user"
                                   name="amount"
                                   placeholder="1000">
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
    <script type="text/javascript">
        $(function () {
            $('#cashoutTable').DataTable({
                paging: false
            });
        })
    </script>
@endpush
