@extends('layouts.app')

@section('title', 'Dashboard')
@push('styles')
    <style>
        .dt-buttons {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    @include('common.breadcrumbs', ['title' => 'Dashboard'])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            {{-- changing month and year --}}
            @if (!auth()->user()->hasRole('truck'))
                <div class="row">
                    {{-- toggle months --}}
                    <div class="col-md-6 mb-8">
                        <div class="form-group">
                            <label for="month">Months</label>
                            <select id="month" class="form-select" name="year">
                                <option value="">Select Month</option>
                                @foreach ($data['months'] as $month)
                                    <option value="{{ $month }}" @selected($month === request()->from_month)>{{ $month }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    {{-- year to date --}}
                    <div class="col-md-6 mb-8">
                        <div class="form-group">
                            <label for="year">Year to Date</label>
                            <select id="year" class="form-select" name="year">
                                <option value="">Select Year</option>
                                @foreach ($data['years'] as $year)
                                    <option value="{{ $year }}" @selected($year == request()->from_year)>{{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-6 mb-5 mb-xl-8">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                <div class="mb-4 px-9">
                                    <div class="d-flex align-items-center mb-2">
                                        <span
                                            class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ str_replace('.00', '', number_format($data['load_shipped'], 2)) }}</span>
                                        <span class="d-flex align-items-end text-gray-400 fs-6 fw-semibold">Tons</span>
                                    </div>
                                    <span class="fs-6 fw-semibold text-gray-400">Tons Shipped</span>
                                </div>
                                <div id="kt_card_widget_12_chart" class="min-h-auto" style="height: 125px"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-6 mb-md-5 mb-xl-8">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                <div class="mb-4 px-9">
                                    <div class="d-flex align-items-center mb-2">
                                        <span
                                            class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">${{ number_format($data['commission'], 2) }}</span>
                                    </div>
                                    <span class="fs-6 fw-semibold text-gray-400">Est. Commission</span>
                                </div>
                                <div id="kt_card_widget_13_chart" class="min-h-auto" style="height: 125px"></div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">
                    {{-- today's load dispatched --}}
                    @include('common.today_loads', ['dispatches' => $data['dispatches']])

                    {{-- scoreboard --}}
                    <div class="col-md-12 mt-4">
                        {{-- <div class="card shadow mb-4">
                            <div class="card-header card-header-height d-flex align-items-center">
                                <h6 class="font-weight-bold text-primary mb-0 pb-0">Scoreboard</h6>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="scoreboard" class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 5%;"></th>
                                                <th data-priority="1">Name</th>
                                                <th data-priority="2">Est. Tons Shipped</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['sales_records'] as $record)
                                                <tr>
                                                    <th class="text-center">{{ $loop->iteration }}</th>
                                                    <td class="text-capitalize">{{ $record->salesman1?->full_name }}</td>
                                                    <td>{{ str_replace('.00', '', number_format($record->total_loads * 24, 2)) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> --}}

                        <div class="card shadow mb-4">
                            <div class="card-header card-header-height d-flex align-items-center">
                                <h6 class="font-weight-bold text-primary mb-0 pb-0">Scoreboard</h6>
                            </div>
                            <div class="card-body">
                                <div id="scoreboard" style="height: 350px;"></div>
                            </div>
                        </div>
                    </div>

                    {{-- top 5 product --}}
                    <div class="col-md-12 mt-4">
                        <div class="card shadow mb-4">
                            <div class="card-header card-header-height d-flex align-items-center">
                                <h6 class="font-weight-bold text-primary mb-0 pb-0">Top 5 Products</h6>
                            </div>

                            <div class="card-body">
                                <div id="topProducts" style="height: 350px;"></div>
                            </div>

                            {{-- <div class="card-body">
                                <div class="table-responsive">
                                    <table id="products" class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 5%;"></th>
                                                <th data-priority="1">Product</th>
                                                <th data-priority="2">Est. Tons Shipped</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['top_products'] as $record)
                                                <tr>
                                                    <th class="text-center">{{ $loop->iteration }}</th>
                                                    <td class="text-capitalize">{{ $record->commodity?->name }}</td>
                                                    <td>{{ str_replace('.00', '', number_format($record->total_loads * 24, 2)) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->hasRole('truck'))
                <div class="row">

                    {{-- today's load dispatched --}}
                    @include('common.today_loads', ['dispatches' => $data['dispatches']])

                    {{-- bulletins --}}
                    @foreach ($bulletins as $bulletin)
                        <div class="col-md-12">
                            <div class="card shadow mb-4">
                                <div class="card-header card-header-height d-flex align-items-center justify-content-between"
                                    style="background-color: rgb(0, 67, 135); font-weight: bold;">
                                    <h4 class="text-white mb-0 pb-0">{{ $bulletin->title }}</h4>
                                    <span class="cursor-pointer read-button" data-id="{{ $bulletin->id }}">
                                        <i class="fa fa-times fs-16 text-danger"></i>
                                    </span>
                                </div>
                                <form id="readBulletinForm{{ $bulletin->id }}"
                                    action="{{ route('bulletins.read', $bulletin) }}" method="POST">
                                    @csrf
                                </form>
                                <div class="card-body">
                                    {!! $bulletin->description !!}
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif


            {{-- <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">Add New Supplier</h6>
                </div>
            </div> --}}

        </div>
    </div>
@endsection

@if (!auth()->user()->hasRole('truck'))
    @push('scripts')
        @include('charts')
    @endpush
@endif

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.read-button').on('click', function() {
                let id = $(this).data('id');
                $(`#readBulletinForm${id}`).submit();
            })

            let table = $('#myTable').DataTable({
                "oLanguage": {
                    "sSearch": "Filter:"
                },
                "bPaginate": false,
                dom: 'frtp',
                buttons: [],
            });

            // let scoreboard = $('#scoreboard').DataTable({
            //     "oLanguage": {
            //         "sSearch": "Filter:"
            //     },
            //     "bPaginate": false,
            //     dom: 'frtp',
            //     buttons: [],
            // });

            // let products = $('#products').DataTable({
            //     "oLanguage": {
            //         "sSearch": "Filter:"
            //     },
            //     "bPaginate": false,
            //     dom: 'rtp',
            //     buttons: [],
            // });

            // get value when month change
            $('#month').on('change', function(e) {
                let currentUrl = window.location.href;

                // remove all search tags from url
                currentUrl = cleanUrl(currentUrl);
                window.location.href = currentUrl + `?from_month=${e.target.value}`;
            })

            // get value when year change
            $('#year').on('change', function(e) {
                let currentUrl = window.location.href;
                // remove all search tags from url
                currentUrl = cleanUrl(currentUrl);

                window.location.href = currentUrl + `?from_year=${e.target.value}`;
            })

            // remove all search tags from url
            function cleanUrl(url) {
                // ceck if url has #
                if (window.location.href.indexOf('#') != -1) {
                    url = window.location.href.substr(0, window.location.href.indexOf('#'))
                }

                // ceck if url has already view search tage for month in request then remove it
                if (url.includes("?from_month=") || url.includes("from_month=")) {
                    url = url.split('?from_month')[0];
                }

                // ceck if url has already view search tage for year in request then remove it
                if (url.includes("?from_year=") || url.includes("from_year=")) {
                    url = url.split('?from_year')[0];
                }

                return url;
            }
        });
    </script>
@endpush
