@extends('layouts.app')

@section('title', 'Commodity Suppliers List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Commodity Suppliers </h1>
            <a href="{{route('commoditie.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="h3 mb-0 text-gray-800">Add Suppliers</h1>
            </div>
                <form method="POST" action="{{route('commoditie.supplierstore')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12 mb-6 mt-6 mb-sm-0">
                                <span style="color:red;">*</span>Status</label>
                                    <select id="supplier_id" class="select2 form-control form-control-user @error('status') is-invalid @enderror" name="supplier_id">
                                        <option selected disabled>Select Supplier</option>
                                        @foreach ($comsuppliers as $comsupplier)
                                            <option value="{{ $comsupplier->id }}">{{ $comsupplier->name }}</option>
                                        @endforeach
                                    </select>
                                @error('status')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror 
                            </div>
                            <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                                <input 
                                    type="hidden" 
                                    class="form-control form-control-user" 
                                    id="examplecommoditie"
                                    name="commoditie_id" 
                                    value="{{$commoditie->id}}">
                        </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                    </div>
                </form>
        </div>
        

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Suppliers of {{$commoditie->name}}</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20%">ID</th>
                                <th width="20%">Suppliers</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier1)
                                <tr>
                                    <td>{{ $supplier1->id }}</td>
                                    <td>{{ $supplier1->name }}</td>
                                    <td style="display: flex">
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" onclick = "ConfirmDelete({{ $supplier1->id }})">
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

    @include('commoditie.commodity-supplier-delete-modal')
    

@endsection

@section('scripts')

<script type = "text/javascript">

    function ConfirmDelete(id){
        $('#commodity-supplier-delete-modal').modal('show');
        $('#confirm_del_id').val(id);
    }

</script>
<script type = "text/javascript">
     $(document).ready(function(){
        $('.select2').select2({});
    });
</script>
@endsection
