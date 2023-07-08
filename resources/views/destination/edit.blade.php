@extends('layouts.app')

@section('title', 'Edit Destination')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Destinations</h1>
            <a href="{{ route('destination.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Destination</h6>
            </div>
            <form method="POST" action="{{ route('destination.update', ['destination' => $destination->id]) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group row">

                        {{-- Name --}}
                        <div class="col-sm-12 mb-3">
                            <span style="color:red;">*</span>Name</label>
                            <input type="text" class="form-control form-control-via @error('name') is-invalid @enderror"
                                id="exampleFirstName" placeholder="Destination Name" name="name"
                                value="{{ old('name', $destination->name) }}">

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="col-sm-12 mb-3">
                            <span style="color:red;">*</span>Address</label>
                            <input type="text"
                                class="form-control form-control-via @error('address') is-invalid @enderror"
                                id="exampleAddress" placeholder="140 Cattle Co 15751 Hwy 140 Livingston" name="address"
                                value="{{ old('address', $destination->address) }}">

                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-sm-12 mb-3">
                            <span style="color:red;">*</span>Status</label>
                            <select class="form-control form-control-destination @error('status') is-invalid @enderror"
                                name="active">
                                <option selected disabled>Select Status</option>
                                <option value="1" @selected(old('active', $destination->active) == 1)>Active</option>
                                <option value="0" @selected(old('active', $destination->active) == 0)>Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-destination float-right mb-3">Update</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('destination.index') }}">Cancel</a>
                </div>
            </form>
        </div>

    </div>


@endsection
