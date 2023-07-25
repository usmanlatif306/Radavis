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
        'title' => 'Truck Directory',
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
                    <h5 class="font-weight-bold text-primary m-0 text-capitalize">{{ $status }} Trucks</h5>
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

                    <div class="table-responsive p-3">
                        <table id="truckTable" class="table table-hover table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="width: 13%;">Company Name</th>
                                    <th>Contact Name</th>
                                    <th>Email Address</th>
                                    <th>Phone Number</th>
                                    <th>Trucks</th>
                                    <th>Equipment</th>
                                    <th>Area</th>
                                    <th>Linked User</th>
                                    <th>Last Dispatch</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($trucks as $truck)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $truck->name }}</td>
                                        <td>{{ $truck->contact_name }}</td>
                                        <td>{{ $truck->email }}</td>
                                        <td>{{ $truck->phone }}</td>
                                        <td>{{ $truck->trucks }}</td>
                                        <td>
                                            @foreach ($truck->equip_type as $equip)
                                                {{ $equip }}{{ $loop->last ? '' : ',' }}
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($truck->service_area as $service)
                                                {{ $service }}{{ $loop->last ? '' : ',' }}
                                            @endforeach
                                        </td>
                                        <td>{!! $truck->user
                                            ? $truck->user?->full_name . '<br>(' . $truck->user?->email . ')'
                                            : '<span class="text-danger">No link</span>' !!}
                                        </td>
                                        <td>{{ $truck->last_dispatch_at?->format('m/d/Y') }}</td>
                                        <td>
                                            @if ($truck->active == 0)
                                                <span class="badge badge-danger">Inactive</span>
                                            @else
                                                <span class="badge badge-success">Active</span>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="">No truck found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {
            var table = $('#truckTable').DataTable({
                "oLanguage": {
                    "sSearch": "Filter:"
                },
                "bPaginate": false,
                dom: 'frtip',
                buttons: [],
            });

            $('.status-btn').on('click', function() {
                let status = $(this).data('status');
                window.location.href = "{{ url('') }}" + `/truck/directory?status=${status}`;
            })
        });
    </script>
@endpush
