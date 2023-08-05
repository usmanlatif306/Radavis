@extends('layouts.app')

@section('title', 'Destination List')
@push('styles')
    <style>
        .dt-buttons {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    @include('common.breadcrumbs', [
        'title' => 'Destination',
        'btn_text' => 'Add New',
        'btn_link' => route('destination.create'),
    ])
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">All Destinations</h6>
                </div>

                <div class="card-body">
                    <table class="table table-hover table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Note</th>
                                <th>Status</th>
                                <th width="20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('destination.delete-modal')
    </div>


@endsection

@push('scripts')
    <script type="text/javascript">
        function ConfirmDelete(id) {
            $('#destinationdeleteModal').modal('show');
            $('#confirm_del_id').val(id);
        }
    </script>
    <script type="text/javascript">
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('destination.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'note',
                        name: 'note'
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
                "oLanguage": {
                    "sSearch": "Filter:"
                },
                stateSave: true,
                // dom: '<"top"lif>rtp',
                dom: 'frtip',
                buttons: [],
            });

        });
    </script>
@endpush
