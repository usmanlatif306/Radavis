@extends('layouts.app')

@section('title', 'Edit Exit')

@section('content')

    @include('common.breadcrumbs', [
        'title' => 'Edit Exits',
        'btn_text' => 'Back',
        'btn_link' => route('exit.index'),
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">Edit Exit</h6>
                </div>

                <form method="POST" action="{{ route('exit.update', ['exit' => $exit->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group row">

                            {{-- Name --}}
                            <div class="col-sm-12 mb-6 mb-sm-0">
                                <span style="color:red;">*</span>Name</label>
                                <input type="text"
                                    class="form-control form-control-via @error('name') is-invalid @enderror"
                                    id="exampleFirstName" placeholder="Name" name="name"
                                    value="{{ old('name', $exit->name) }}">

                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                                <span style="color:red;">*</span>Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="active">
                                    <option selected disabled>Select Status</option>
                                    <option value="1" {{ $exit->active == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $exit->active == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-exit float-right mb-3">Update</button>
                        <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('exit.index') }}">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>



@endsection
