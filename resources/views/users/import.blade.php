@extends('layouts.app')

@section('title', 'Import Users')

@section('content')
    @include('common.breadcrumbs', [
        'title' => 'Import Users',
        'btn_text' => 'Back',
        'btn_link' => route('users.index'),
    ])
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">Import Users</h6>
                </div>

                <form method="POST" action="{{ route('users.upload') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">

                            <div class="col-md-12">
                                <p>Please Upload CSV in Given Format <a href="{{ asset('files/sample-data-sheet.csv') }}"
                                        target="_blank">Sample CSV Format</a></p>
                            </div>
                            {{-- File Input --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>File Input(Datasheet)</label>
                                <input type="file"
                                    class="form-control form-control-user @error('file') is-invalid @enderror"
                                    id="exampleFile" name="file" value="{{ old('file') }}">

                                @error('file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-user float-right mb-3">Upload Users</button>
                        <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('users.index') }}">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
