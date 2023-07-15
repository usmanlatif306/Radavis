@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        @if (!auth()->user()->hasRole('truck'))
            <!-- Content Row -->
            <div class="row">
                {{-- toggle months --}}
                <div class="col-md-6 mb-2">
                    <div class="form-group">
                        <label for="month">Months</label>
                        <select id="month" class="form-control" name="year">
                            <option value="">Select Month</option>
                            @foreach ($data['months'] as $month)
                                <option value="{{ $month }}" @selected($month === request()->from_month)>{{ $month }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>
                {{-- year to date --}}
                <div class="col-md-6 mb-2">
                    <div class="form-group">
                        <label for="year">Year to Date</label>
                        <select id="year" class="form-control" name="year">
                            <option value="">Select Year</option>
                            @foreach ($data['years'] as $year)
                                <option value="{{ $year }}" @selected($year == request()->from_year)>{{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- TONS SHIPPED --}}
                <div class="col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        TONS SHIPPED</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ str_replace('.00', '', number_format($data['load_shipped'], 2)) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-truck fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- COMMISSION EARNED --}}
                <div class="col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        COMMISSION EARNED</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        ${{ number_format($data['commission'], 2) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                {{-- scoreboard --}}
                <div class="col-md-12 mt-4">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Scoreboard</h1>
                    </div>

                    <div class="table-responsive">
                        <table id="scoreboard" class="table table-hover table-bordered responsive" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;"></th>
                                    <th data-priority="1">Name</th>
                                    <th data-priority="2">Load Shipped (Tons)</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['sales_records'] as $record)
                                    <tr>
                                        <th class="text-center">{{ $loop->iteration }}</th>
                                        <td class="text-capitalize">{{ $record->salesman1?->full_name }}</td>
                                        <td>{{ str_replace('.00', '', number_format($record->total_loads * 24, 2)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- top 5 product --}}
                <div class="col-md-12 mt-4">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Top 5 Products</h1>
                    </div>

                    <div class="table-responsive">
                        <table id="products" class="table table-hover table-bordered responsive" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;"></th>
                                    <th data-priority="1">Product</th>
                                    <th data-priority="2">Load Shipped (Tons)</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['top_products'] as $record)
                                    <tr>
                                        <th class="text-center">{{ $loop->iteration }}</th>
                                        <td class="text-capitalize">{{ $record->commodity?->name }}</td>
                                        <td>{{ str_replace('.00', '', number_format($record->total_loads * 24, 2)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            {{-- bulletin for truck users --}}
            @if (
                $bulletin &&
                    auth()->user()->hasRole('truck'))
                <div class="col-md-12">
                    <div class="d-flex align-items-center justify-content-between"
                        style="background-color: rgb(0, 67, 135); color: white; padding: 10px; font-weight: bold;">
                        <h3 class="mb-0 pb-0">{{ $bulletin->title }}</h3>
                        <form action="{{ route('bulletins.read', $bulletin) }}" method="POST">
                            @csrf
                            <button type="submit" class="close text-danger">
                                <i class="fa fa-times"></i>
                            </button>
                        </form>
                    </div>

                    <div style="border: 1px solid rgb(0, 67, 135); border-top: none; padding: 20px; margin: 0 0 20px 0">
                        {!! $bulletin->description !!}
                    </div>
                </div>
            @endif

            {{-- today's load dispatched --}}
            <div class="col-md-12 mt-4">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Today’s loads</h1>
                </div>

                <div class="table-responsive">
                    <table id="myTable" class="table table-hover table-bordered responsive" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th data-priority="1">Commodity</th>
                                <th data-priority="2">Destination</th>
                                <th>Rate</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['dispatches'] as $dispatch)
                                <tr class="{{ $dispatch->release_code == '' ? 'table-info' : ' ' }}{{ $dispatch->noship == 1 ? 'table-danger' : ' ' }}{{ $dispatch->void == 1 ? 'table-dark' : ' ' }}{{ $dispatch->delivered == 1 ? 'table-success' : ' ' }}"
                                    @if ($dispatch->void == 1) style="background-color: #D3D3D3; text-decoration: line-through;" @endif>
                                    <td style="color:{{ $dispatch->commodity?->color ?? '' }};font-weight: bold;">
                                        <span>{!! $dispatch->commodity?->name ?? $dispatch->commodity_id !!}</span>
                                    </td>
                                    <td><span>{!! $dispatch->destination?->name ?? $dispatch->destination_id !!}<br>{!! $dispatch->destination?->address !!}</span>
                                    </td>
                                    <td>{!! $dispatch->rate->name ?? $dispatch->rate_id !!}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let table = $('#myTable').DataTable({
                "oLanguage": {
                    "sSearch": "Filter:"
                },
                "bPaginate": false,
                stateSave: true,
                dom: '<"top"if>Brtip',
            });

            let scoreboard = $('#scoreboard').DataTable({
                "oLanguage": {
                    "sSearch": "Filter:"
                },
                "bPaginate": true,
                dom: '<"top"if>Brtip',
            });

            let products = $('#products').DataTable({
                "oLanguage": {
                    "sSearch": "Filter:"
                },
                "bPaginate": false,
                dom: '<"top"if>Brtip',
            });

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


@endsection
