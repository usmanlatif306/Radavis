@extends('layouts.app')

@section('title', 'Exits List')
@push('styles')
    <style>
        .dt-buttons {
            display: none !important;
        }
    </style>
@endpush

@section('content')

    @include('common.breadcrumbs', [
        'title' => 'Exits',
        'btn_text' => 'Add New',
        'btn_link' => route('exit.create'),
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">All Exits</h6>
                </div>

                <div class="card-body">
                    <table class="table table-hover table-bordered data-table">
                        <thead>
                            <tr>
                                <th style="width: 15%;">No</th>
                                <th>Name</th>
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
        @include('exit.delete-modal')
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
                ajax: "{{ route('exit.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
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
    </script>
@endpush
