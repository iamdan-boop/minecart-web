@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Announcement</h6>
            </div>
            <form method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control form-control-user"
                               name="title"
                               value="">
                        @error('title')
                        <span class="text-danger text-sm ml-2">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group mt-2">
                        <label>Announcement Body</label>
                        <textarea type="text" id="body_editor" class="form-control form-control-user"
                                  name="body" rows="10" cols="80"></textarea>

                        @error('body')
                        <span class="text-danger text-sm ml-2">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="d-flex flex-col">
                        <div class="ml-auto">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            CKEDITOR.replace('body_editor');
        })
    </script>
@endpush



