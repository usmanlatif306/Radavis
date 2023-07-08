@extends('layouts.app')

@section('title', 'Bulletins List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bulletins</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('bulletins.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>

            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Bulletins</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20%">Title</th>
                                <th width="50%">Description</th>
                                <th width="20%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bulletins as $bulletin)
                                <tr>
                                    <td>{{ $bulletin->title }}</td>
                                    <td>{{ $bulletin->description }}</td>
                                    <td>
                                        @if ($bulletin->status == 0)
                                            <span class="badge badge-danger">Inactive</span>
                                        @elseif ($bulletin->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                    <td style="display: flex">
                                        @if ($bulletin->status == 0)
                                            <a href="{{ route('bulletins.status', ['bulletin' => $bulletin->id, 'status' => 1]) }}"
                                                class="btn btn-success m-2">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        @elseif ($bulletin->status == 1)
                                            <a href="{{ route('bulletins.status', ['bulletin' => $bulletin->id, 'status' => 0]) }}"
                                                class="btn btn-danger m-2">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('bulletins.show', $bulletin) }}" class="btn btn-primary m-2">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('bulletins.edit', $bulletin) }}" class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal"
                                            data-target="#deleteModal{{ $bulletin->id }}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $bulletins->links() }}
                </div>
            </div>
        </div>

    </div>
    @foreach ($bulletins as $bulletin)
        @include('bulletins.delete-modal')
    @endforeach

@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myTable').DataTable({
                "oLanguage": {
                    "sSearch": "Filter:"
                },
                "lengthChange": false,
                paging: false,
                info: false,
                stateSave: true,
                dom: '<"top"lif>rtp'
            });
        });
    </script>

@endsection
