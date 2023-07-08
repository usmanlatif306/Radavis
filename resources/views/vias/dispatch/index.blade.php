@extends('layouts.app')

@section('title', 'Dispatch')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sx-flex     mb-4">
            <h1 class="h3 mb-0 text-gray-600">Live Dispatch</h1>
            <div class="row justify-content-md-center">

                <?php
                if (isset($_GET['date'])) {
                    $date = $_GET['date'];
                } else {
                    $date = date('m/d/Y');
                }
                ?>

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

                <!-- <div class="col-sm-3 mb-3 mt-3 ml-6 mb-sm-0" >
                                        Date</label>
                                            <input class="form form-control" type="date" name="date" id="date_view" value="<?php //echo isset($_GET['date']) ? $_GET['date'] : "default";
                                            ?>">
                                        </div> -->
                <!-- <div class="col-md-3 mb-3 mt-3 mb-sm-0" style="margin-left: 70%;">-->
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
                                <?php
                                /*<th id = "t-id">Id</th>*/
                                ?>
                                <th id="t-commodity">Commodity</th>
                                <?php
                                /*<th id = "t-supplier">Supplier</th>
                                <th id = "t-purchase">Purchase Code</th>*/
                                ?>
                                <th id="t-exit">Exit</th>
                                <th id="t-release">Release Code</th>
                                <th id="t-via">Via</th>
                                <th id="t-destination">Destination</th>
                                <th id="t-rate">Rate</th>
                                <?php
                                /*<th id = "t-saleman">Saleman</th>
                                <th id = "t-sales">Sales No.</th>
                                <th id = "t-set">Set</th>
                                <th id = "t-dns">DNS</th>
                                @if($config[7]->value == 'show')
                                <th id= "t-drivernotes">Driver Notes</th>
                                <th id= "t-salesnotes">Sales</th>
                                <th id= "t-accountingnotes">Accounting</th>
                                @endif*/
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dispatches as $dispatch)
                                <tr
                                    class="{{ $dispatch->release_code == '' ? 'table-info' : ' ' }}{{ $dispatch->noship == 1 ? 'table-warning' : ' ' }}{{ $dispatch->void == 1 ? 'table-danger' : ' ' }}{{ $dispatch->delivered == 1 ? 'table-success' : ' ' }}">
                                    <td>{!! date('m/d/Y', $dispatch->date) !!}</td>
                                    <?php
                                    /*<td>{!! $dispatch->id!!}</td>*/
                                    ?>
                                    <td
                                        style="color:{{ isset($dispatch->commodity->color) ? $dispatch->commodity->color : '' }};font-weight: bold;">
                                        {!! $dispatch->commodity->name ?? $dispatch->commodity_id !!}</td>
                                    <?php
                                    /*<td> {!! $dispatch->supplier->name ?? $dispatch->supplier_id!!}</td>
                            <td>{!! $dispatch->purchase_code ?? ' '!!}</td>*/
                                    ?>
                                    <td>{!! $dispatch->exit->name ?? $dispatch->exit_id !!}</td>
                                    <td>{!! $dispatch->release_code ?? ' ' !!}</td>
                                    <td>{!! $dispatch->via->name ?? $dispatch->via_id !!}</td>
                                    <td>{!! $dispatch->destination->name ?? $dispatch->destination_id !!}</td>
                                    <td>{!! $dispatch->rate->name ?? $dispatch->rate_id !!}</td>
                                    <?php
                                    /*<td>{!! $dispatch->salesman1->first_name ?? ' '!!}</td>
                            <td>{!! $dispatch->sales_num ?? ' '!!}</td>
                            <td >
                            @if ($dispatch->delivered == 0)
                                <a href="{{ route('dispatch.updatedelivered', ['id' => $dispatch->id, 'delivered' => 1]) }}" class="">
                                    <i class="fa fa-times"></i>
                                </a>
                            @elseif ($dispatch->delivered == 1)
                                <a href="{{ route('dispatch.updatedelivered', ['id' => $dispatch->id, 'delivered' => 0]) }}" class="">
                                    <i class="fa fa-check"></i>
                                </a>
                            @endif

                            </td>
                            <td>
                            @if ($dispatch->noship == 0)
                                <a href="{{ route('dispatch.updatenoship', ['id' => $dispatch->id, 'noship' => 1]) }}" class="">
                                    <i class="fa fa-times"></i>
                                </a>
                            @elseif ($dispatch->noship == 1)
                                <a href="{{ route('dispatch.updatenoship', ['id' => $dispatch->id, 'noship' => 0]) }}" class="">
                                    <i class="fa fa-check"></i>
                                </a>
                            @endif
                            </td>
                            @hasrole('Admin')
                            <!-- <td style="display: flex">
                                <a href="#" data-toggle="modal"
                                    class="btn btn-primary m-2">
                                    <i class="fa fa-pen"></i>
                                </a> -->
                            <!-- <a class="btn btn-danger m-2" href="#" data-toggle="modal"
                                    onclick="ConfirmDelete({{ $dispatch->id }})">
                                    <i class="fas fa-trash"></i>
                                </a> -->
                            <!-- </td> -->
                            @endhasrole
                            @if($config[7]->value == 'show')
                                @if($dispatch->driver_instructions != ' ')
                                <td>{!! $dispatch->driver_instructions ?? ' '!!}</td>
                                @endif
                                @if($dispatch->sales_notes != ' ' )
                                <td>{!! $dispatch->sales_notes ?? ' '!!}</td>
                                @endif
                                @if($dispatch->accounting_notes != ' ')
                                <td>{!! $dispatch->accounting_notes ?? ' ' !!}</td>
                                @endif
                            @endif*/
                                    ?>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>

    </div>

    @include('dispatch.create')
    @include('dispatch.bulkedit')

    @include('dispatch.edit')

    @include('dispatch.delete-modal')

    @include('dispatch.changelog')

@endsection

@section('scripts')
    @include('dispatch.js')
@endsection
