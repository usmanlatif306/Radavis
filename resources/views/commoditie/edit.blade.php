@extends('layouts.app')

@section('title', 'Edit Commoditie')

@section('content')

    @include('common.breadcrumbs', [
        'title' => 'Edit Commodities',
        'btn_text' => 'Back',
        'btn_link' => route('commoditie.index'),
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header pt-4" style="min-height: 50px !important;">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Commoditie</h6>
                </div>
                <form method="POST" action="{{ route('commoditie.update', ['commoditie' => $commoditie->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group row">
                            {{-- Name --}}
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <span style="color:red;">*</span>Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="exampleFirstName" placeholder="Name" name="name"
                                    value="{{ old('name', $commoditie->name) }}">

                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Color --}}
                            <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                                <span style="color:red;">*</span>Color</label>
                                <input type="color"
                                    class="form-control form-control-commoditie @error('color') is-invalid @enderror"
                                    id="exampleColorInput" placeholder="#FFFFFF" name="color"
                                    value="{{ old('color', $commoditie->color) }}">

                                @error('color')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                                <span style="color:red;">*</span>Status</label>
                                <select class="form-select form-control-commoditie @error('status') is-invalid @enderror"
                                    name="active">
                                    <option selected disabled>Select Status</option>
                                    <option value="1" {{ $commoditie->active == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $commoditie->active == 0 ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-commoditie float-right mb-3">Update</button>
                        <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('commoditie.index') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection
