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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h6 class="mr-5 font-weight-bold text-primary ">My Items</h6>
                        </div>
                        <button class="btn btn-success col-12 col-lg-3 mt-2 mx-auto mt-lg-0"
                                data-toggle="modal" data-target="#createItemModal">Create
                            New Item
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemsTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Buyer Name</th>
                                <th>Status</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->buyer_name }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->note }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <button id="viewItemBtn" class="btn btn-block btn-primary" data-toggle="modal"
                                                data-target="#viewItem"
                                                data-object="{{ json_encode($item) }}"
                                        >
                                            <span class="fa fa-eye"></span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($items->links()->paginator->hasPages())
                        <div class="mt-4 p-4 d-flex justify-content-end align-items-end">
                            {{ $items->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{--  Create Item  --}}
    <div class="modal fade" id="createItemModal" tabindex="-1" role="dialog"
         aria-labelledby="createItemModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('customer.items.store') }}" method="POST">
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
                                <input class="form-check-input" type="radio" name="type" id="food"
                                       value="{{ \App\Models\Item::$ITEM_TYPE_FOOD }}">
                                <label class="form-check-label" for="food">Food</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="others"
                                       value="{{ \App\Models\Item::$ITEM_TYPE_OTHERS }}">
                                <label class="form-check-label" for="others">Others</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="seller_price">Seller Price</label>
                            <input id="seller_price" class="form-control form-control-user" type="number" name="price"
                                   placeholder="100.00">
                        </div>

                        <div class="form-group">
                            <label for="note">Notes</label>
                            <textarea id="note" class="form-control form-control-user" name="note"></textarea>
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



    {{--  View Item  --}}
    <div class="modal fade" id="viewItem" tabindex="-1" role="dialog"
         aria-labelledby="viewItem"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="buyer_name">Buyer Name</label>
                            <input id="buyer_name" type="text" class="form-control form-control-user"
                                   placeholder="Buyer Name" readonly>
                        </div>


                        <div class="form-group col-sm-6">
                            <label for="price">My Price</label>
                            <input id="price" type="text" class="form-control form-control-user"
                                   placeholder="Price" readonly>
                        </div>
                    </div>


                    <div class="row mt-2">
                        <div class="form-group col-sm-6">
                            <label for="drop_date">Drop Date</label>
                            <input id="drop_date" type="text" class="form-control form-control-user"
                                   placeholder="Buyer Name" readonly>
                        </div>


                        <div class="form-group col-sm-6">
                            <label for="pickup_date">Pickup Date</label>
                            <input id="pickup_date" type="text" class="form-control form-control-user"
                                   placeholder="Price" readonly>
                        </div>
                    </div>


                    <div class="row mt-2">
                        <div class="form-group col-sm-6">
                            <label for="item_final_price">Item Final Price</label>
                            <input id="item_final_price" type="text" class="form-control form-control-user"
                                   placeholder="0" readonly>
                        </div>


                        <div class="form-group col-sm-6">
                            <label for="status">Status</label>
                            <input id="status" type="text" class="form-control form-control-user"
                                   placeholder="Status" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="note_view">Notes</label>
                        <textarea id="note_view" class="form-control form-control-user" name="note" readonly>

                        </textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            $('#itemsTable').DataTable({
                paging: false
            });

            $('#viewItemBtn').click(function () {
                const item = $(this).data('object');
                console.log(item)
                $('#buyer_name').val(item.buyer_name)
                $('#price').val(item.price)
                $('#drop_date').val(item.drop_date)
                $('#pickup_date').val(item.pickup_date)
                $('#item_final_price').val(item.display_price)
                $('#status').val(item.status)
                $('#note_view').val(item.note)
            })
        })
    </script>
@endpush
