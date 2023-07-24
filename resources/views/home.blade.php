@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @include('common.breadcrumbs', ['title' => 'Home'])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

        </div>
    </div>
@endsection
