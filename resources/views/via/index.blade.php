@extends('layouts.app')

@section('title', 'Trucks List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Trucks</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('via.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
                <!-- <div class="col-md-6">
                                                                                                <a href="{{ route('via.export') }}" class="btn btn-sm btn-success">
                                                                                                    <i class="fas fa-check"></i> Export To Excel
                                                                                                </a>
                                                                                            </div> -->

            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        @php
            $status = request()->status === 'inactive' ? 'inactive' : 'active';
        @endphp

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Trucks</h6>
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <button type="button"
                        class="btn btn-sm @if ($status === 'active') btn-primary @else btn-outline-primary @endif status-btn"
                        data-status="active">Active</button>
                    <button type="button"
                        class="btn btn-sm @if ($status === 'inactive') btn-primary @else btn-outline-primary @endif status-btn"
                        data-status="inactive">Inactive</button>
                </div>
            </div>
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>

    @include('via.delete-modal')

@endsection

@section('scripts')

    <script type="text/javascript">
        function ConfirmDelete(id) {
            $('#deleteModal').modal('show');
            $('#confirm_del_id').val(id);
        }
    </script>
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "oLanguage": {
                    "sSearch": "Filter:"
                },
                // ajax: "{{ route('via.index') }}",
                ajax: "{{ url('') }}" + '/via?status={{ $status }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                // stateSave: true,
                dom: '<"top"lif>rtp'
            });

        });

        $('.status-btn').on('click', function() {
            let status = $(this).data('status');
            window.location.href = "{{ url('') }}" + `/via?status=${status}`;
        })
    </script>

@endsection
