@extends('layouts.app')

@section('title', 'Suppliers List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Suplliers</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
                <!-- <div class="col-md-6">
                    <a href="{{ route('supplier.export') }}" class="btn btn-sm btn-success">
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
                <h6 class="m-0 font-weight-bold text-primary">All Suppliers</h6>

            </div>
            
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Supplier</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>     
        </div>

    </div>

    @include('supplier.delete-modal')

@endsection

@section('scripts')

<script type="text/javascript">
$(document).ready(function(){
    $('.exitindex').click(function(){
        window.location = $(this).attr('href');
        return false;
    });
});

function ConfirmDelete(id){
    $('#supplierdeleteModal').modal('show');
    $('#confirm_del_id').val(id);
}
</script>
<script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('supplier.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name_added', name: 'name'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        stateSave: true,
        dom: '<"top"lif>rtp'
    });
    
  });
</script> 
    
@endsection
