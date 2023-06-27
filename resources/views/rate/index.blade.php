@extends('layouts.app')

@section('title', 'Rate List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rates</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('rate.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
                <!-- <div class="col-md-6">
                    <a href="{{ route('rate.export') }}" class="btn btn-sm btn-success">
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
                <h6 class="m-0 font-weight-bold text-primary">All Rates</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    
            <form method="POST" action="{{route('rate.store')}}">
            @csrf
            <div class="card-body col-sm-4 mb-6 mt-6 mb-sm-0">
                <div class="form-group row">

                    {{-- First Name --}}
                    <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                        <span style="color:red;">*</span>Name</label>
                        <?php 
                        
                        $value = NULL;
                        foreach ($rates as $record_num=>$row)
                        {
                            if ($row->active == TRUE)
                            {
                                $value .= $row->name . "\n";
                            }
                        }
                        
                        ?>
                        <textarea name= "name" rows = "8" class = "form-control form-control-user @error('name') is-invalid @enderror">{{$value}}</textarea>

                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                

                </div>
            </div>

            <div class="card-footer col-sm-4 mb-6 mt-6 mb-sm-0">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('rate.index') }}">Cancel</a>
            </div>
        </form>
                
                <!-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20%">ID</th>
                                <th width="20%">Rate</th>
                                <th width="15%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rates as $rate)
                                <tr>
                                    <td>{{ $rate->id }}</td>
                                    <td>{{ $rate->name }}</td>
                                    <td>
                                        @if ($rate->active == 0)
                                            <span class="badge badge-danger">Inactive</span>
                                        @elseif ($rate->active == 1)
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                    <td style="display: flex">
                                        @if ($rate->active == 0)
                                            <a href="{{ route('rate.status', ['rate_id' => $rate->id, 'active' => 1]) }}"
                                                class="btn btn-success m-2">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        @elseif ($rate->active == 1)
                                            <a href="{{ route('rate.status', ['rate_id' => $rate->id, 'active' => 0]) }}"
                                                class="btn btn-danger m-2">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('rate.edit', ['rate' => $rate->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" onclick = "ConfirmDelete({{ $rate->id }})">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> -->

                    
                </div>
            </div>
        </div>

    </div>

    @include('rate.delete-modal')

@endsection

@section('scripts')

<script type = "text/javascript">

function ConfirmDelete(id){
    $('#ratedeleteModal').modal('show');
    $('#confirm_del_id').val(id);
}

</script>
    
@endsection
