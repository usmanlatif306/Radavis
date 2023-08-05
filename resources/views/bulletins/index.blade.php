@extends('layouts.app')

@section('title', 'Bulletins List')
@push('styles')
    <style>
        .dt-buttons {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    @include('common.breadcrumbs', [
        'title' => 'Bulletins',
        'btn_text' => 'Add New',
        'btn_link' => route('bulletins.create'),
    ])
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">All Bulletins</h6>
                </div>

                <div class="card-body">
                    <table class="table table-hover table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('bulletins.delete-modal')
    </div>


@endsection

@push('scripts')
    <script type="text/javascript">
        function ConfirmDelete(id) {
            $('#bulletinDeleteModal').modal('show');
            $('#confirm_bulletin_id').val(id);
        }
    </script>

    <script type="text/javascript">
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('bulletins.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
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
@endpush
