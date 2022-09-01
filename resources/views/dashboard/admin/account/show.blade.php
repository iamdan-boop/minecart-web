@extends('layouts.dashboard')

@push('styles')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endpush

@section('dashboard-content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Account: {{ $account->name }}</h6>
                <h6 class="m-0 font-weight-bold text-black-50">Wallet: <span
                        class="text-success font-weight-bold">{{ number_format(1000, 2) }}</span></h6>
            </div>
            <form action="{{ route('accounts.update', $account) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control form-control-user"
                               name="name"
                               value="{{ $account->name }}">
                        @error('name')
                        <span class="text-danger text-sm ml-2">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group mt-2">
                        <label>Email</label>
                        <input type="email" class="form-control form-control-user"
                               name="email"
                               value="{{ $account->email }}">

                        @error('email')
                        <span class="text-danger text-sm ml-2">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group mt-2">
                        <label>Password</label>
                        <input type="password" class="form-control form-control-user"
                               name="password"
                               value="">
                        <span class="text-danger text-sm ml-2">Fill this out only <b>IF</b> you are going to change your password</span>
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


    <div class="container mt-10">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Items</h6>
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#createItemModal">Add
                        New Item
                    </button>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-1">For Approval</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-2">For Claiming</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-3">Claimed</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-4">Pullout</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="tab-1" class="container tab-pane active"><br>
                        <h3>Tab-1</h3>
                    </div>

                    <div id="tab-2" class="container tab-pane fade"><br>
                        <h3>Tab-2</h3>
                    </div>

                    <div id="tab-3" class="container tab-pane fade"><br>
                        <h3>Tab-3</h3>
                    </div>

                    <div id="tab-4" class="container tab-pane fade">
                        <h3>Tab 4</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="createItemModal" tabindex="-1" role="dialog"
         aria-labelledby="createItemModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Buyer Name</label>
                            <input type="text" class="form-control form-control-user"
                                   name="buyer_name"
                                   placeholder="Buyer Name">
                        </div>

                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="item_type" id="food" value="food">
                                <label class="form-check-label" for="food">Food</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="item_type" id="others"
                                       value="others">
                                <label class="form-check-label" for="others">Others</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Seller Price</label>
                            <input class="form-control form-control-user" type="number" name="price"
                                   placeholder="100.00">
                        </div>

                        <div class="form-group">
                            <label>Notes</label>
                            <textarea class="form-control form-control-user"></textarea>
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
