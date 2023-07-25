@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

    @include('common.breadcrumbs', [
        'title' => 'Edit Users',
        'btn_text' => 'Back',
        'btn_link' => route('users.index'),
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">Edit User</h6>
                </div>

                <form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group row">

                            {{-- First Name --}}
                            <div class="col-sm-6 mb-6">
                                <span style="color:red;">*</span>First Name</label>
                                <input type="text"
                                    class="form-control form-control-user @error('first_name') is-invalid @enderror"
                                    id="exampleFirstName" placeholder="First Name" name="first_name"
                                    value="{{ old('first_name') ? old('first_name') : $user->first_name }}">

                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Last Name --}}
                            <div class="col-sm-6 mb-6">
                                <span style="color:red;">*</span>Last Name</label>
                                <input type="text"
                                    class="form-control form-control-user @error('last_name') is-invalid @enderror"
                                    id="exampleLastName" placeholder="Last Name" name="last_name"
                                    value="{{ old('last_name') ? old('last_name') : $user->last_name }}">

                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-sm-6 mb-6">
                                <span style="color:red;">*</span>Email</label>
                                <input type="text"
                                    class="form-control form-control-user @error('email') is-invalid @enderror"
                                    id="exampleEmail" placeholder="Email" name="email"
                                    value="{{ old('email') ? old('email') : $user->email }}">

                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Mobile Number --}}
                            <div class="col-sm-6 mb-6">
                                <span style="color:red;">*</span>Mobile Number</label>
                                <input type="text"
                                    class="form-control form-control-user @error('mobile_number') is-invalid @enderror"
                                    id="exampleMobile" placeholder="Mobile Number" name="mobile_number"
                                    value="{{ old('mobile_number') ? old('mobile_number') : $user->mobile_number }}">

                                @error('mobile_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Role --}}
                            <div class="col-sm-6 mb-6">
                                <span style="color:red;">*</span>Role</label>
                                <select class="form-select text-capitalize @error('role_id') is-invalid @enderror"
                                    name="role_id">
                                    <option selected disabled>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-sm-6 mb-6">
                                <span style="color:red;">*</span>Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status">
                                    <option selected disabled>Select Status</option>
                                    <option value="1"
                                        {{ old('role_id') ? (old('role_id') == 1 ? 'selected' : '') : ($user->status == 1 ? 'selected' : '') }}>
                                        Active</option>
                                    <option value="0"
                                        {{ old('role_id') ? (old('role_id') == 0 ? 'selected' : '') : ($user->status == 0 ? 'selected' : '') }}>
                                        Inactive</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-6">
                                <label class="labels">New Password</label>
                                <input type="password" name="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror"
                                    placeholder="New Password">
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                        <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('users.index') }}">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection
