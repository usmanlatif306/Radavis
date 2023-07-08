@extends('layouts.app')

@section('title', 'Bulletins List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bulletins</h1>
            {{-- <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('bulletins.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div> --}}
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Bulletins</h6>

            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('bulletins.update', $bulletin) }}">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        {{-- Title --}}
                        <div class="col-12 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Title</label>
                            <input type="text"
                                class="form-control form-control-user @error('title') is-invalid @enderror" id="Title"
                                placeholder="Title" name="title" value="{{ old('title', $bulletin->title) }}">

                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="col-12 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Description</label>
                            <textarea name="description" id="description" cols="30" rows="10"
                                class="form-control form-control-user @error('description') is-invalid @enderror">{{ old('description', $bulletin->description) }}</textarea>

                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>

                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection
@section('scripts')
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
@endsection
