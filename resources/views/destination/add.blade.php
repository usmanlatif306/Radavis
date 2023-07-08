@extends('layouts.app')

@section('title', 'Add Destination')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Destination</h1>
            <a href="{{ route('destination.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add New Destination</h6>
            </div>
            <form method="POST" action="{{ route('destination.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">

                        {{--  Name --}}
                        <div class="col-sm-12 mb-3">
                            <span style="color:red;">*</span>Name</label>
                            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
                                id="exampleName" placeholder="Destination Name" name="name" value="{{ old('name') }}">

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="col-sm-12 mb-3">
                            <span style="color:red;">*</span>Address</label>
                            <input type="text"
                                class="form-control form-control-user @error('address') is-invalid @enderror"
                                id="exampleAddress" placeholder="140 Cattle Co 15751 Hwy 140 Livingston" name="address"
                                value="{{ old('address') }}">

                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-sm-12 mb-3">
                            <span style="color:red;">*</span>Status</label>
                            <select class="form-control form-control-user @error('status') is-invalid @enderror"
                                name="active">
                                <option selected disabled>Select Status</option>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('destination.index') }}">Cancel</a>
                </div>
            </form>
        </div>

    </div>


@endsection
