@extends('layouts.app')

@section('title', 'Users List')
@push('styles')
    <style>
        .dt-buttons {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    @include('common.breadcrumbs', [
        'title' => 'Users',
        'btn_text' => 'Add New',
        'btn_link' => route('users.create'),
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">All Users</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="20%">Name</th>
                                    <th width="25%">Email</th>
                                    <th width="15%">Mobile</th>
                                    <th width="15%">Role</th>
                                    <th width="15%">Status</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile_number }}</td>
                                        <td>{{ $user->roles ? $user->roles->pluck('name')->first() : 'N/A' }}</td>
                                        <td>
                                            @if ($user->status == 0)
                                                <span class="badge badge-danger">Inactive</span>
                                            @elseif ($user->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @endif
                                        </td>
                                        <td style="display: flex">
                                            @if ($user->status == 0)
                                                <a href="{{ route('users.status', ['user_id' => $user->id, 'status' => 1]) }}"
                                                    class="btn btn-sm btn-success m-2">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            @elseif ($user->status == 1)
                                                <a href="{{ route('users.status', ['user_id' => $user->id, 'status' => 0]) }}"
                                                    class="btn btn-sm btn-danger m-2">
                                                    <i class="fa fa-ban"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                                class="btn btn-sm btn-primary m-2">
                                                <i class="fa fa-pen"></i>
                                            </a>
                                            <a class="btn btn-sm btn-danger m-2" href="#" data-toggle="modal"
                                                data-target="#deleteModal">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- {{ $users->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
        @include('users.delete-modal')
    </div>



@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myTable').DataTable({
                "oLanguage": {
                    "sSearch": "Filter:"
                },
                "lengthChange": false,
                stateSave: true,
                // dom: '<"top"lif>rtp',
                dom: 'frtip',
                buttons: [],
            });
        });
    </script>
@endpush
