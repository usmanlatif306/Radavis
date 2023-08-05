@extends('layouts.app')

@section('title', 'Add Destination')

@section('content')
    @include('common.breadcrumbs', [
        'title' => 'Add Destination',
        'btn_text' => 'Back',
        'btn_link' => route('destination.index'),
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header d-flex align-items-center card-header-height">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">Add New Destination</h6>
                </div>

                <form method="POST" action="{{ route('destination.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            {{--  Name --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>Name</label>
                                <input type="text"
                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                    id="exampleName" placeholder="Destination Name" name="name"
                                    value="{{ old('name') }}">

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>Address</label>
                                <input type="text"
                                    class="form-control form-control-user @error('address') is-invalid @enderror"
                                    id="exampleAddress" placeholder="140 Cattle Co 15751 Hwy 140 Livingston" name="address"
                                    value="{{ old('address') }}">

                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Note --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>Note</label>
                                <input type="text"
                                    class="form-control form-control-user @error('note') is-invalid @enderror"
                                    id="exampleNote" placeholder="Destination Note" name="note"
                                    value="{{ old('note') }}">

                                @error('note')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="active">
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
    </div>



@endsection
