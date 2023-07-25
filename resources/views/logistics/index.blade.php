@extends('layouts.app')

@section('title', 'Logistics')

@section('content')
    @include('common.breadcrumbs', [
        'title' => 'Logistics',
        // 'btn_text' => 'Add New',
        // 'btn_link' => route('supplier.create'),
    ])


@endsection
