@extends('layouts.app')

@section('title', 'Add Bulletin')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Bulletin</h1>
            <a href="{{ route('bulletins.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add New Bulletin</h6>
            </div>
            <form method="POST" action="{{ route('bulletins.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">

                        {{-- Title --}}
                        <div class="col-12 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Title</label>
                            <input type="text"
                                class="form-control form-control-user @error('title') is-invalid @enderror" id="Title"
                                placeholder="Title" name="title" value="{{ old('title') }}">

                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="col-12 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Description</label>
                            <textarea name="description" id="description" cols="30" rows="10"
                                class="form-control form-control-user @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-12 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Status</label>
                            <select class="form-control form-control-user @error('status') is-invalid @enderror"
                                name="status">
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
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('bulletins.index') }}">Cancel</a>
                </div>
            </form>
        </div>

    </div>


@endsection
