@extends('layouts.dashboard')


@push('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush


@section('dashboard-content')

    <div>
        <div class="container">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="mr-5 font-weight-bold text-primary ">Claimed Items</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemsTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Buyer Name</th>
                                <th>Type</th>
                                <th>Self Location</th>
                                <th>Handling Fee</th>
                                <th>Seller Name</th>
                                <th>Price</th>
                                <th>Drop Date</th>
                                <th>Shelf Life Till</th>
                                <th>Note</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->buyer_name }}</td>
                                    <td>{{ $item->type == \App\Models\Item::$ITEM_TYPE_FOOD ? 'FOOD' : 'OTHERS' }}</td>
                                    <td>{{ $item->shelf_location }}</td>
                                    <td>{{ $item->handling_fee }}</td>
                                    <td>{{ $item->owner->name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->drop_date }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->note }}</td>
                                    <td>
                                        <div class="container">
                                            <div class="row align-items-center justify-content-center">
                                                <button id="viewItemBtn" class="btn btn-block btn-primary mb-2"
                                                        data-toggle="modal"
                                                        data-target="#viewItemModal"
                                                        data-object="{{ json_encode($item) }}"
                                                >View
                                                </button>
                                                <button id="updateItemBtn" class="btn btn-block btn-success mb-2"
                                                        data-toggle="modal"
                                                        data-target="#updateItemModal"
                                                        data-object="{{ json_encode($item) }}"
                                                >Edit Item
                                                </button>

                                                <form action="{{ route('items.update-return', $item) }}" method="POST"
                                                      onsubmit="return confirm('Are you sure to return this item?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-block btn-warning mb-2">
                                                        Return / Unclaim
                                                    </button>
                                                </form>


                                                <form action="{{ route('items.destroy', $item) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this item?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Remove Item
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
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
    <div class="modal fade" id="updateItemModal" tabindex="-1" role="dialog"
         aria-labelledby="updateItemModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" id="itemDropForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Claiming Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group d-flex align-items-center justify-content-center">
                            <h5 class="h5">Buyer Name : <b id="buyer_name"></b></h5>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-center">
                            <h5 class="h5">Sellers Price : <b id="sellers_price">0.0 PHP</b></h5>
                        </div>


                        <div class="form-group d-flex align-items-center justify-content-center">
                            <h5 class="h5">Handling Fee : <b id="handling_fee">0.0 PHP</b></h5>
                        </div>

                        <div class="form-group">
                            <label for="handling_fee_input">Handling Fee</label>
                            <input id="handling_fee_input" class="form-control form-control-user" type="number"
                                   name="handling_fee"
                                   placeholder="0.00">
                        </div>

                        <div class="form-group">
                            <label for="sellers_price_input">Seller Price</label>
                            <input id="sellers_price_input" class="form-control form-control-user" type="number"
                                   name="price"
                                   placeholder="0.00">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="submitItemDropped" class="btn btn-success">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{--  Create Item  --}}
    <div class="modal fade" id="claimItemModal" tabindex="-1" role="dialog"
         aria-labelledby="claimItemModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" id="claimItemForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Claiming Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group d-flex align-items-center justify-content-center">
                            <h5 class="h5">Buyer Name : <b id="buyer_name_claim"></b></h5>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-center">
                            <h5 class="h5">Sellers Price : <b id="sellers_price_claim">0 PHP</b></h5>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-center">
                            <h5 class="h5">Handling Fee : <b id="handling_fee_claim">0 PHP</b></h5>
                        </div>

                        <div class="form-group">
                            <label for="sellers_money_input">Sellers Money</label>
                            <input id="sellers_money_input" class="form-control form-control-user" type="number"
                                   name="price"
                                   placeholder="0.00">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="submitItemDropped" class="btn btn-success">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{--  View Item  --}}
    <div class="modal fade" id="viewItemModal" tabindex="-1" role="dialog"
         aria-labelledby="viewItemModal"
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
                            <label for="buyer_name_view">Buyer Name</label>
                            <input id="buyer_name_view" type="text" class="form-control form-control-user"
                                   placeholder="Buyer Name" readonly>
                        </div>


                        <div class="form-group col-sm-6">
                            <label for="price_view">My Price</label>
                            <input id="price_view" type="text" class="form-control form-control-user"
                                   placeholder="Price" readonly>
                        </div>
                    </div>


                    <div class="row mt-2">
                        <div class="form-group col-sm-6">
                            <label for="drop_date_view">Drop Date</label>
                            <input id="drop_date_view" type="text" class="form-control form-control-user"
                                   placeholder="Buyer Name" readonly>
                        </div>


                        <div class="form-group col-sm-6">
                            <label for="pickup_date_view">Pickup Date</label>
                            <input id="pickup_date_view" type="text" class="form-control form-control-user"
                                   placeholder="Price" readonly>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="status">Status</label>
                        <input id="status" type="text" class="form-control form-control-user"
                               placeholder="Status" readonly>
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

            $('#updateItemBtn').click(function () {
                const item = $(this).data('object');
                $('#buyer_name').text(item.buyer_name)
                $('#sellers_price').text(item.price.toFixed(2))
                $('#handling_fee').text(item.handling_fee.toFixed(2))
                $('#handling_fee_input').val(item.handling_fee)
                $('#shelf_location').val(item.shelf_location)
                $('#sellers_price_input').val(item.price)
                $('#note').val(item.note)

                $('#itemDropForm').attr('action', "/admin/items/" + item.id + "/update-claim")
            })


            $('#claimItemBtn').click(function () {
                const item = $(this).data('object')
                $('#buyer_name_claim').text(item.buyer_name)
                $('#sellers_price_claim').text(item.price)
                $('#handling_fee_claim').text(item.handling_fee.toFixed(2))

                $('#handling_fee_input').val(item.handling_fee)
                $('#sellers_price_input').val(item.price)

                $('#claimItemForm').attr('action', "/admin/items/" + item.id + "/claim")
            })


            $('#viewItemBtn').click(function () {
                const item = $(this).data('object')
                $('#buyer_name_view').val(item.buyer_name)
                $('#price_view').val(item.price)
                $('#drop_date_view').val(item.drop_date)
                $('#pickup_date_view').val(item.claimed_date)
                $('#status_view').val(item.status)
                $('#note_view').val(item.note)
            })
        })
    </script>
@endpush
