@extends('layouts.app')

@section('title', 'Dispatch')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dispatch</h1>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-sm btn-success" href="#" data-toggle="modal" data-target="#createModal">
                    <i class="fas fa-plus"></i> Add New
                </a>
            </div>
            <!-- <div class="col-md-6">
                <a href="{{ route('dispatch.export') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-check"></i> Export To Excel
                </a>
            </div> -->

        </div>

    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All dispatches</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Date</th>
                            <th>Commodity</th>
                            <th>Supplier</th>
                            <th>Exit</th>
                            <th>Via</th>
                            <th>Destination</th>
                            <th>Rate</th>
                            <th>Saleman</th>
                            <th>Sales No.</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dispatches as $dispatch)
                        <tr>
                            <td>{{ $dispatch->id}}</td>
                            <td>{{ date('M dS Y', strtotime($dispatch->date))}}</td>
                            <td>{{ $dispatch->commodity->name}}</td>
                            <td>{{ $dispatch->supplier->name}}</td>
                            <td>{{ $dispatch->exit->name}}</td>
                            <td>{{ $dispatch->via->name}}</td>
                            <td>{{ $dispatch->destination->name}}</td>
                            <td>{{ $dispatch->rate->name}}</td>
                            <td>{{ $dispatch->salesman}}</td>
                            <td>{{ $dispatch->sales_num}}</td>
                            <td style="display: flex">
                                <a href="#" data-toggle="modal" onclick="EditDispatch({{ $dispatch->id }})"
                                    class="btn btn-primary m-2">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a class="btn btn-danger m-2" href="#" data-toggle="modal"
                                    onclick="ConfirmDelete({{ $dispatch->id }})">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@include('dispatch.edit')

@include('dispatch.delete-modal')

@endsection

@section('scripts')
<script type="text/javascript">
function ConfirmDelete(id) {
    $('#deleteModal').modal('show');
    $('#confirm_del_id').val(id);
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function EditDispatch(id) {
    $('#editModal').modal('show');
    $.ajax({
        type: 'POST',
        url: '{{ route('
        dispatch.getdispatch ')}}',
        "_token": "{{ csrf_token() }}",
        data: {
            dispatch: id
        },
        success: function(data) {
            var Editdate = new Date(data[0].date).toISOString().substring(0, 10);
            $('#dispatch').val(data[0].id);
            $('#edit-commoditie').val(data[0].commodity_id);
            $('#edit-commoditie').trigger('change');
            setTimeout(() => {
                $('#edit-supplier').val(data[0].supplier_id);
                $('#edit-supplier').trigger('change');
            }, 3000);
            $('#editdate').val(Editdate);
            setTimeout(() => {
                $('#edit-exits').val(data[0].exit_id);
            }, 6000);
            $('#editpurchasecode').val(data[0].purchase_code);
            $('#editreleasecode').val(data[0].release_code);
            $('#edit-via').val(data[0].via_id);
            $('#edit-destination').val(data[0].destination_id);
            $('#edit-rate').val(data[0].rate_id);
            $('#edit-salesman').val(data[0].salesman);
            $('#edit-sales_num').val(data[0].sales_num);
            $('#edit_sales_notes').val(data[0].sales_notes);
            $('#edit_accounting_notes').val(data[0].accounting_notes);
            $('#edit_driver_instructions').val(data[0].driver_instructions);
            $('#edit_delivered').val(data[0].delivered);
            $('#edit_noship').val(data[0].noship);
            $('#edit_void').val(data[0].void);
        }
    });

    $('#confirm_del_id').val(id);
}

function EditUpdateSuppliers() {
    value = $('#edit-commoditie').find(':selected').val();
    $.ajax({
        type: 'POST',
        url: '{{ route('
        dispatch.getCommoditieSuppliers ')}}',
        "_token": "{{ csrf_token() }}",
        data: {
            id: value
        },
        success: function(data) {
            $('#edit-supplier').html(data);
        }
    });
}

function EditUpdateexits() {
    value = $('#edit-supplier').find(':selected').val();
    $.ajax({
        type: 'POST',
        url: '{{ route('
        dispatch.getSuppliersExits ')}}',
        "_token": "{{ csrf_token() }}",
        data: {
            id: value
        },
        success: function(data) {
            $('#edit-exits').html(data);
        }
    });
}


function UpdateSuppliers() {
    value = $('#add-commoditie').find(':selected').val();
    $.ajax({
        type: 'POST',
        url: '{{ route('
        dispatch.getCommoditieSuppliers ')}}',
        "_token": "{{ csrf_token() }}",
        data: {
            id: value
        },
        success: function(data) {
            $('#add-supplier').html(data);
        }
    });
}

function Updateexits() {
    value = $('#add-supplier').find(':selected').val();
    $.ajax({
        type: 'POST',
        url: '{{ route('
        dispatch.getSuppliersExits ')}}',
        "_token": "{{ csrf_token() }}",
        data: {
            id: value
        },
        success: function(data) {
            $('#add-exits').html(data);
        }
    });
}
</script>
@endsection