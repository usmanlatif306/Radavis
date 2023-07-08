@extends('layouts.app')

@section('title', 'Edit Truck')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Truck</h1>
            <a href="{{ route('via.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Truck</h6>
            </div>
            <form method="POST" action="{{ route('via.update', ['via' => $via->id]) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group row">

                        {{-- Name --}}
                        <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                            <span style="color:red;">*</span>Name</label>
                            <input type="text" class="form-control form-control-via @error('name') is-invalid @enderror"
                                id="exampleFirstName" placeholder="Name" name="name"
                                value="{{ old('name') ? old('name') : $via->name }}">

                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Link User --}}
                        <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                            <label><span style="color:red;">*</span>Link User</label>
                            <select id="user"
                                class="form-control form-control-user @error('user_id') is-invalid @enderror"
                                name="user_id">
                                <option selected disabled>Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id', $via->user_id) == $user->id)>
                                        {{ $user->full_name . ' (' . $user->email . ')' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-sm-12 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Status</label>
                            <select class="form-control form-control-via @error('status') is-invalid @enderror"
                                name="active">
                                <option selected disabled>Select Status</option>
                                <option value="1" {{ $via->active == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $via->active == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-via float-right mb-3">Update</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('via.index') }}">Cancel</a>
                </div>
            </form>
        </div>

    </div>


@endsection
