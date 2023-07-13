@extends('layouts.app')

@section('title', 'Dispatch')
@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.2/css/jquery.dataTables.css" />
    <style>
        td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sx-flex     mb-4">
            <h1 class="h3 mb-0 text-gray-600">Live Dispatch</h1>
            <div class="row justify-content-md-center">

                @php
                    if (isset($_GET['date'])) {
                        $date = $_GET['date'];
                    } else {
                        $date = date('m/d/Y');
                    }
                    $display_notes = 'show';
                    $view = 'all';
                @endphp

                <div class="col-sm-4 mb-2 mt-6 mb-sm-0">

                </div>

                <?php $changedisplay = session('changedisplay');
                //dd($changedisplay);
                ?>

                <div class="col-md-12 mb-3 mt-3 mb-sm-0" style="text-align:center">
                    <a href="{{ route('dispatch.index', ['date' => date('m/d/Y', strtotime($date . ' -1 day'))]) }}"
                        class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i></a>
                    <input class="btn btn-sm btn-success" type="date" name="date" id="date_view"
                        value="<?php echo isset($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date('Y-m-d'); ?>">
                    <!--<input  class="btn btn-sm btn-success" type="date" name="date" id="date_view" value="<?php echo isset($_GET['date']) ? date('Y-m-d', strtotime($date . ' +1 day')) : date('Y-m-d', strtotime($date . ' +1 day')); ?>">-->
                    <a href="{{ route('dispatch.index', ['date' => date('m/d/Y', strtotime($date . ' +1 day'))]) }}"
                        class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i></a>
                </div>
                <div style="margin-left: 70%;">
                    <label>Display</label>
                    <select class="form form-control" name="dispatch_display" onchange="ChangeDisptachDisplay()"
                        id="dispatch_display" style="text-align: end;">
                        <option value="completed" @if ($changedisplay == 'completed') selected @endif>Completed</option>
                        <option value="open" @if ($changedisplay == 'open') selected @endif>Open</option>
                        <option value="ship" @if ($changedisplay == 'ship') selected @endif>Ready to Ship</option>
                        <option value="noship" @if ($changedisplay == 'noship') selected @endif>NO Ship</option>
                        <option value="void" @if ($changedisplay == 'void') selected @endif>Void</option>
                        <option value="all" @if ($changedisplay == 'all') selected @endif>ALL</option>
                    </select>
                </div>
            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 row">
                <h6 class="ml-3 m-0 font-weight-bold text-primary">All dispatches</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover table-bordered" id="dataTable" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th id="t-commodity">Commodity</th>
                                <th id="t-supplier">Supplier</th>
                                <th id="t-exit">Exit</th>
                                <th id="t-release">Release Code</th>
                                <th id="t-via">Via</th>
                                <th id="t-destination">Destination</th>
                                <th id="t-rate">Rate</th>
                                <th>Status</th>
                                <th class="d-none">Driver Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dispatches as $dispatch)
                                <tr
                                    class="{{ $dispatch->release_code == '' ? 'table-info' : ' ' }}{{ $dispatch->noship == 1 ? 'table-warning' : ' ' }}{{ $dispatch->void == 1 ? 'table-danger' : ' ' }}{{ $dispatch->delivered == 1 ? 'table-success' : ' ' }}">
                                    <td>{!! date('m/d/Y', $dispatch->date) !!}</td>
                                    <td
                                        style="color:{{ isset($dispatch->commodity->color) ? $dispatch->commodity->color : '' }};font-weight: bold;">
                                        {!! $dispatch->commodity->name ?? $dispatch->commodity_id !!}</td>
                                    <td> {!! $dispatch->supplier->name ?? $dispatch->supplier_id !!}</td>
                                    <td>{!! $dispatch->exit->name ?? $dispatch->exit_id !!}</td>
                                    <td>{!! $dispatch->release_code ?? ' ' !!}</td>
                                    <td>{!! $dispatch->via->name ?? $dispatch->via_id !!}</td>
                                    <td>{!! $dispatch->destination->name ?? $dispatch->destination_id !!}</td>
                                    <td>{!! $dispatch->rate->name ?? $dispatch->rate_id !!}</td>
                                    <td>
                                        <button onclick="document.getElementById('complete-{{ $dispatch->id }}').submit();"
                                            class="btn btn-sm btn-success">{{ $dispatch->delivered ? 'Reset' : 'Loaded' }}</button>
                                        <form id="complete-{{ $dispatch->id }}"
                                            action="{{ route('dispatch.complete', $dispatch) }}" method="post">
                                            @csrf
                                        </form>
                                    </td>
                                    <td class="d-none">{{ $dispatch->driver_instructions }}</td>
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
    @include('vias.dispatch.js')
@endsection
