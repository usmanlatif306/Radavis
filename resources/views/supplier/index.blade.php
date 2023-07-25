@extends('layouts.app')

@section('title', 'Suppliers List')
@push('styles')
    <style>
        .dt-buttons {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    @include('common.breadcrumbs', [
        'title' => 'Suppliers',
        'btn_text' => 'Add New',
        'btn_link' => route('supplier.create'),
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">All Suppliers</h6>
                </div>

                <div class="card-body">
                    <table class="table table-hover table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>

            @include('supplier.delete-modal')
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.exitindex').click(function() {
                window.location = $(this).attr('href');
                return false;
            });
        });

        function ConfirmDelete(id) {
            $('#supplierdeleteModal').modal('show');
            $('#confirm_del_id').val(id);
        }
    </script>
    <script type="text/javascript">
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('supplier.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name_added',
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
