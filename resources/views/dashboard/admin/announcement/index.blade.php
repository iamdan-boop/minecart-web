@extends('layouts.dashboard')


@push('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush


@section('dashboard-content')
    <div>
        <div class="container">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h6 class="mr-5 font-weight-bold text-primary ">Announcements</h6>
                        </div>
                        <a class="btn btn-success col-12 col-lg-3 mt-2 mx-auto mt-lg-0"
                           href="{{ route('announcements.create') }}">Create
                            Announcement</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="announcementTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date Posted</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($announcements as $announcement)
                                <tr>
                                    <td>{{ $announcement->title }}</td>
                                    <td>{{ $announcement->created_at }}</td>
                                    <td>
                                        <a class="btn btn-block btn-primary"
                                           href="{{ route('announcements.show', $announcements) }}">
                                            <span class="fa fa-eye"></span>
                                        </a>
                                        <form action="{{ route('announcements.destroy', $announcements) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete ' + '{{ $announcement->title }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-block mt-2 btn-danger">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ( $announcements->links()->paginator->hasPages())
                        <div class="mt-4 p-4 d-flex justify-content-end align-items-end">
                            {{ $announcements->links() }}
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
            $('#announcementTable').DataTable({
                paging: false
            });
        })
    </script>
@endpush
