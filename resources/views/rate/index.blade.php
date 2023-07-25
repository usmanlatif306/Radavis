@extends('layouts.app')

@section('title', 'Rate List')

@section('content')
    @include('common.breadcrumbs', [
        'title' => 'Rates',
        'btn_text' => 'Add New',
        'btn_link' => route('rate.create'),
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">All Rates</h6>
                </div>
                <form method="POST" action="{{ route('rate.store') }}">
                    @csrf
                    <div class="card-body col-sm-4 mb-6 mb-sm-0">
                        <div class="form-group row">

                            {{-- First Name --}}
                            <div class="col-sm-12 mb-6 mb-sm-0">
                                <span style="color:red;">*</span>Name</label>
                                <?php
                                
                                $value = null;
                                foreach ($rates as $record_num => $row) {
                                    if ($row->active == true) {
                                        $value .= $row->name . "\n";
                                    }
                                }
                                
                                ?>
                                <textarea name="name" rows="8" class="form-control form-control-user @error('name') is-invalid @enderror">{{ $value }}</textarea>

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer col-sm-4 mb-6 mt-6 mb-sm-0">
                        <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                        <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('rate.index') }}">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @include('rate.delete-modal')

@endsection

@push('scripts')
    <script type="text/javascript">
        function ConfirmDelete(id) {
            $('#ratedeleteModal').modal('show');
            $('#confirm_del_id').val(id);
        }
    </script>
@endpush
