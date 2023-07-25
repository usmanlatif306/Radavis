@extends('layouts.app')

@section('title', 'Trucks List')
@push('styles')
    <style>
        .dt-buttons {
            display: none !important;
        }
    </style>
@endpush

@section('content')

    @include('common.breadcrumbs', [
        'title' => 'Trucks',
        'btn_text' => 'Add New',
        'btn_link' => route('via.create'),
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            @php
                $status = request()->status === 'inactive' ? 'inactive' : 'active';
            @endphp

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bold text-primary m-0">All Trucks</h5>
                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <button type="button"
                            class="btn btn-sm @if ($status === 'active') btn-primary @else btn-outline-primary @endif status-btn"
                            data-status="active">Active</button>
                        <button type="button"
                            class="btn btn-sm @if ($status === 'inactive') btn-primary @else btn-outline-primary @endif status-btn"
                            data-status="inactive">Inactive</button>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-hover table-bordered data-table">
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
        </div>
        @include('via.delete-modal')
    </div>
@endsection

@push('scripts')
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
                stateSave: true,
                dom: 'frtip',
                buttons: [],
            });

        });

        $('.status-btn').on('click', function() {
            let status = $(this).data('status');
            window.location.href = "{{ url('') }}" + `/via?status=${status}`;
        })
    </script>
@endpush
