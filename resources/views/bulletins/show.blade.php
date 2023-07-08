@extends('layouts.app')

@section('title', 'Show Bulletin')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Show Bulletin</h1>
            <a href="{{ route('bulletins.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Show Bulletin</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 15%;">Title</th>
                            <td>{{ $bulletin->title }}</td>
                        </tr>
                        <tr>
                            <th scope="row" style="width: 15%;">Description</th>
                            <td>{{ $bulletin->description }}</td>
                        </tr>
                        <tr>
                            <th scope="row" style="width: 15%;">Status</th>
                            <td>
                                @if ($bulletin->status == 0)
                                    <span class="badge badge-danger p-1">Inactive</span>
                                @elseif ($bulletin->status == 1)
                                    <span class="badge badge-success p-1">Active</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>


@endsection
