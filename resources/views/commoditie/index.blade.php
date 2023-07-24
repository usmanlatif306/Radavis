@extends('layouts.app')

@section('title', 'Commodities List')

@section('content')
    @include('common.breadcrumbs', ['title' => 'Commodities'])
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bold text-primary m-0">All Commodities</h5>
                    <a href="{{ route('commoditie.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add New
                    </a>
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

        </div>
    </div>

    @include('commoditie.delete-modal')

@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.supplierindex').click(function() {
                window.location = $(this).attr('href');
                return false;
            });
        });

        function ConfirmDelete(id) {
            $('#commoditydeleteModal').modal('show');
            $('#confirm_del_id').val(id);
        }
    </script>
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                ajax: "{{ route('commoditie.index') }}",
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
                order: [
                    [0, 'asc']
                ],
                stateSave: true,
                "oLanguage": {
                    "sSearch": "Filter:"
                },
                // dom: '<"top"lif>rtp'

            });

        });
    </script>
@endpush
