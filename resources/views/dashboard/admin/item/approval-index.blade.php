@extends('layouts.dashboard')


@push('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush


@section('dashboard-content')
    <div>
        <div class="container">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="mr-5 font-weight-bold text-primary ">For Approval</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemsTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Buyer Name</th>
                                <th>Type</th>
                                <th>Seller Name</th>
                                <th>Price</th>
                                <th>Note</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->buyer_name }}</td>
                                    <td>{{ $item->type == \App\Models\Item::$ITEM_TYPE_FOOD ? 'FOOD' : 'OTHERS' }}</td>
                                    <td>{{ $item->owner->name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->note }}</td>
                                    <td>
                                        <div class="container row align-items-center justify-content-between">
                                            <button id="itemDropBtn" class="btn btn-success mb-2 mb-lg-0"
                                                    data-toggle="modal"
                                                    data-target="#itemDropModal"
                                                    data-object="{{ json_encode($item) }}"
                                            >Item Drop
                                            </button>

                                            <form action="{{ route('items.destroy', $item) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you wanted to delete this item ' + '{{ $item->buyer_name }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger">Remove Item</button>
                                            </form>
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
    <div class="modal fade" id="itemDropModal" tabindex="-1" role="dialog"
         aria-labelledby="itemDropModal"
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
                            <h5 class="h5">Sellers Price : <b id="sellers_price">1000 PHP</b></h5>
                        </div>

                        <div class="form-group">
                            <label for="handling_fee">Handling Fee</label>
                            <input id="handling_fee" class="form-control form-control-user" type="number"
                                   name="handling_fee"
                                   placeholder="0.00">
                        </div>


                        <div class="form-group">
                            <label for="shelf_location">Shelf ID</label>
                            <input id="shelf_location" class="form-control form-control-user" type="text"
                                   name="shelf_location"
                                   placeholder="Shelf ID">
                        </div>

                        <div class="form-group">
                            <label for="note">Item Note Description</label>
                            <textarea id="note" class="form-control form-control-user" name="note"></textarea>
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

@endsection



@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('#itemsTable').DataTable({
                paging: false
            });

            $('#itemDropBtn').click(function () {
                const item = $(this).data('object');
                $('#buyer_name').text(item.buyer_name)
                $('#sellers_price').text(item.price.toFixed(2))
                $('#note').val(item.note)

                $('#itemDropForm').attr('action', "/admin/items/" + item.id + "/approve")
            })
        })
    </script>
@endpush
