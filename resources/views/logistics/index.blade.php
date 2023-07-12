@extends('layouts.app')

@section('title', 'Logistics')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Logistics</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

    </div>

@endsection
