@extends('layouts.dashboard')


@push('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush


@section('dashboard-content')
    <div>
        <div class="container">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Accounts</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="treatmentAreaTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Account Name</th>
                                <th>Account Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($accounts as $account)
                                <tr>
                                    <td>{{ $account->name }}</td>
                                    <td>{{ $account->email }}</td>
                                    <td>{{ $account->isBantay() ? 'BANTAY' : 'USER' }}</td>
                                    <td>
                                        <div class="container">
                                            <a href="{{ route('accounts.show', $account) }}"
                                               class="btn btn-block btn-primary">
                                                <span class="fa fa-eye"></span>
                                            </a>

                                            @if($account->isBantay())
                                                <form action="{{ route('account.toUserRole', $account) }}" method="POST"
                                                      class="mt-2">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" class="btn btn-block btn-success">Set as User
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('account.toBantayRole', $account) }}"
                                                      method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" class="btn btn-block btn-success">Set as
                                                        Bantay
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                    {{--                                    <td>--}}
                                    {{--                                        <div>--}}
                                    {{--                                            <a href="{{ route('department.show', $department) }}"--}}
                                    {{--                                               class="btn btn-success" id="buttonView">VIEW</a>--}}
                                    {{--                                            <button class="btn btn-warning updateDepartmentBtn" data-toggle="modal"--}}
                                    {{--                                                    data-target="#updateDepartment"--}}
                                    {{--                                                    data-id="{{ $department->id }}"--}}
                                    {{--                                                    data-name="{{ $department->department_name }}">EDIT--}}
                                    {{--                                            </button>--}}
                                    {{--                                            <button class="btn btn-danger deleteTreatmentBtn" data-toggle="modal"--}}
                                    {{--                                                    data-target="#deleteDepartment"--}}
                                    {{--                                                    data-id="{{ $department->id }}"--}}
                                    {{--                                                    data-name="{{ $department->department_name }}">DELETE--}}
                                    {{--                                            </button>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($accounts->links()->paginator->hasPages())
                        <div class="mt-4 p-4 d-flex justify-content-end align-items-end">
                            {{ $accounts->links() }}
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
    <script type="text/javascript">
        $(function () {
            $('#treatmentAreaTable').DataTable({
                paging: false
            });
        })
    </script>
@endpush
