@extends('layouts.app')

@section('title', 'Blank Page')

@section('content')
    @include('common.breadcrumbs', [
        'title' => 'Blank Page',
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')
        </div>
    </div>
@endsection
