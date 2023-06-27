@extends('layouts.app')

@section('title', 'Edit Rate')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit rates</h1>
        <a href="{{route('rate.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Rate</h6>
        </div>
        <form method="POST" action="{{route('rate.update', ['rate' => $rate->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Name --}}
                    <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                        <span style="color:red;">*</span>Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-via @error('name') is-invalid @enderror" 
                            id="exampleFirstName"
                            placeholder="Name" 
                            name="name" 
                            value="{{ old('name') ?  old('name') : $rate->name}}">

                        @error('first_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                        <span style="color:red;">*</span>Status</label>
                        <select class="form-control form-control-rate @error('status') is-invalid @enderror" name="active">
                            <option selected disabled>Select Status</option>
                            <option value="1" {{($rate->active == 1) ? 'selected' : ''}}>Active</option>
                            <option value="0" {{($rate->active == 0) ? 'selected' : ''}}>Inactive</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-rate float-right mb-3">Update</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('rate.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection