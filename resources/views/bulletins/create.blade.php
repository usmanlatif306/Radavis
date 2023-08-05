@extends('layouts.app')

@section('title', 'Add Bulletin')

@section('content')
    @include('common.breadcrumbs', [
        'title' => 'Add Bulletin',
        'btn_text' => 'Back',
        'btn_link' => route('bulletins.index'),
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header d-flex align-items-center card-header-height">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">Add New Bulletin</h6>
                </div>

                <form method="POST" action="{{ route('bulletins.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">

                            {{-- Title --}}
                            <div class="col-12 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>Title</label>
                                <input type="text"
                                    class="form-control form-control-user @error('title') is-invalid @enderror"
                                    id="Title" placeholder="Title" name="title" value="{{ old('title') }}">

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
                                <select class="form-select @error('status') is-invalid @enderror" name="status">
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
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption',
                    'ImageStyle',
                    'ImageToolbar', 'ImageUpload', 'MediaEmbed'
                ],
            });
    </script>
@endpush
