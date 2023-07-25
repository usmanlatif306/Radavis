@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @include('common.breadcrumbs', ['title' => 'Home'])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">Add New Supplier</h6>
                </div>
            </div>

        </div>
    </div>
@endsection
