@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                                                                                                                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
        </div>

        <div class="row">
            @if (count($bulletins) > 0)
                <div class="col-md-12">
                    @foreach ($bulletins as $bulletin)
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <form action="{{ route('bulletins.read', $bulletin) }}" method="POST">
                                @csrf
                                <button type="submit" class="close">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>

                            <strong>{{ $bulletin->title }}</strong>
                            <p>{{ $bulletin->description }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- dispatched --}}
            <div class="col-md-12 mt-4">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dispatch</h1>
                </div>

                <div class="table-responsive">
                    <table id="myTable" class="table table-hover table-bordered responsive" id="dataTable" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                @if (Auth::user()->hasRole('salesman'))
                                    <th></th>
                                    <th>Date</th>
                                    <?php /*<th>Id</th>*/ ?>
                                    <th data-priority="1">Commodity</th>
                                    <?php /*<th>Supplier</th>
                                    <th>Purchase Code</th>*/
                                    ?>
                                    <th>Exit</th>
                                    <th>Release Code</th>
                                    <th data-priority="2">Via</th>
                                    <th data-priority="3">Destination</th>
                                    <th>Rate</th>
                                    <?php /*<th>Saleman</th>
                                    <th>Sales No.</th>
                                    <th>Set</th>
                                    <th>DNS</th>
                                    @if($config[7]->value == 'show')
                                    <th>Driver</th>
                                    <th>Sales</th>
                                    <th>Accounts</th>
                                    @endif */
                                    ?>
                                @else
                                    <th data-priority="1">Commodity</th>
                                    <th data-priority="2">Destination</th>
                                    <th>Rate</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dispatches as $dispatch)
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
    {{-- @include('dispatch.js') --}}
    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                "oLanguage": {
                    "sSearch": "Filter:"
                },
                "bPaginate": false,
                stateSave: true,

                dom: '<"top"if>Brtip',
                /*dom: 'Bfrtip',*/
                buttons: [
                    'print',
                ],
            });
        });
    </script>

@endsection
