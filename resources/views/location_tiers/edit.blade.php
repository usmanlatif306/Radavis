@extends('layouts.app')

@section('title', 'Edit Location Tier')

@section('content')

    @include('common.breadcrumbs', [
        'title' => 'Edit Location Tier',
        'btn_text' => 'Back',
        'btn_link' => route('tiers.index'),
    ])
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">Edit Location Tier</h6>
                </div>

                <form method="POST" action="{{ route('tiers.update', $tier) }}">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group row">
                            {{-- Name --}}
                            <div class="col-12 mb-6">
                                <span style="color:red;">*</span>Tier Name</label>
                                <input type="text"
                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                    id="name" placeholder="Name of Location Tier" name="name"
                                    value="{{ old('name', $tier->name) }}">

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Starting --}}
                            <div class="col-12 mb-6">
                                <span style="color:red;">*</span>Starting Mileage</label>
                                <input type="text"
                                    class="form-control form-control-user @error('starting') is-invalid @enderror"
                                    id="starting" placeholder="Starting Mileage" name="starting"
                                    value="{{ old('starting', $tier->starting) }}">

                                @error('starting')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Ending --}}
                            <div class="col-12 mb-6">
                                <span style="color:red;">*</span>Ending Mileage</label>
                                <input type="text"
                                    class="form-control form-control-user @error('ending') is-invalid @enderror"
                                    id="ending" placeholder="Ending Mileage" name="ending"
                                    value="{{ old('ending', $tier->ending) }}">

                                @error('ending')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div class="col-12 mb-6">
                                <span style="color:red;">*</span>Price</label>
                                <input type="text"
                                    class="form-control form-control-user @error('price') is-invalid @enderror"
                                    id="price" placeholder="Price For Location Tier" name="price"
                                    value="{{ old('price', $tier->price) }}">

                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-12 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status">
                                    <option selected disabled>Select Status</option>
                                    <option value="1" @selected(old('status', $tier->status) == 1 ? 'selected' : '')>Active</option>
                                    <option value="0" @selected(old('status', $tier->status) == 0 ? 'selected' : '')>Inactive</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                        <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('tiers.index') }}">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>


@endsection
