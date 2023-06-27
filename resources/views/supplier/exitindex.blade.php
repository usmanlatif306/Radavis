@extends('layouts.app')

@section('title', 'Suppliers exit List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Supplier exits </h1>
            <a href="{{route('supplier.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="h3 mb-0 text-gray-800">Add Exit</h1>
            </div>
                <form method="POST" action="{{route('supplier.exitstore')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12 mb-6 mt-6 mb-sm-0">
                                <span style="color:red;">*</span>Exits</label>
                                    <select id="exit_id" class="select2 form-control form-control-user @error('Exit') is-invalid @enderror" name="exit_id">
                                        <option selected disabled>Select Exits</option>
                                        @foreach ($exitall as $exit)
                                            <option value="{{ $exit->id }}">{{ $exit->name }}</option>
                                        @endforeach
                                    </select>
                                @error('Exit')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror 
                            </div>
                            <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                                <input 
                                    type="hidden" 
                                    class="form-control form-control-user" 
                                    id="examplecommoditie"
                                    name="supplier_id" 
                                    value="{{$supplier->id}}">
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
                <h6 class="m-0 font-weight-bold text-primary">All Exits of {{$supplier->name}}</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20%">ID</th>
                                <th width="20%">Exits</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exits as $exit)
                                <tr>
                                    <td>{{ $exit->id }}</td>
                                    <td>{{ $exit->name }}</td>
                                    <td style="display: flex">
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" onclick = "ConfirmDelete({{ $exit->id }})">
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

    @include('supplier.supplier-exit-delete-modal')
    
    

@endsection

@section('scripts')
<script type = "text/javascript">
     $(document).ready(function(){
        $('.select2').select2({});
    });
</script>

<script type = "text/javascript">

function ConfirmDelete(id){
    $('#supplier-exit-delete-modal').modal('show');
    $('#confirm_del_id').val(id);
}

</script>
@endsection
