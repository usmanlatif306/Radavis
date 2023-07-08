@extends('layouts.app')

@section('title', 'Dispatch')

@section('content')
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" />
    <style>
        @import url('//cdn.datatables.net/1.10.2/css/jquery.dataTables.css');

        td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
    </style>
    <?php
    /*<style>
    @media print{
        @page {
            size: landscape;
        }
    }
</style>*/
    ?>
    <?php
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
    } else {
        $date = date('m/d/Y');
    }
    ?>

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dispatch</h1>
            <?php /*<a href="{{route('dispatch.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>*/
            ?>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')


        <button class="accordion font-weight-bold text-primary @if (!$bOpenSearch) active @endif"><b>Daily
                View</b></button>
        <div class="panel" @if (!$bOpenSearch) style="display: block;" @endif>
            <div class="col-md-12 mb-3 mt-3 mb-sm-0" style="text-align:center">
                <a href="{{ route('dispatch.searchview', ['date' => date('m/d/Y', strtotime($date . ' -1 day'))]) }}"
                    class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i></a>
                <input class="btn btn-sm btn-success" type="date" name="date" id="date_view"
                    value="<?php echo isset($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date('Y-m-d'); ?>">
                <!--<input  class="btn btn-sm btn-success" type="date" name="date" id="date_view" value="<?php echo isset($_GET['date']) ? date('Y-m-d', strtotime($date . ' +1 day')) : date('Y-m-d', strtotime($date . ' +1 day')); ?>">-->
                <a href="{{ route('dispatch.searchview', ['date' => date('m/d/Y', strtotime($date . ' +1 day'))]) }}"
                    class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i></a>
                <div style="margin-left: 80%;">
                    <?php $changedisplay = session('changedisplay');
                    //dd($changedisplay);
                    ?>
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

        <button class="accordion font-weight-bold text-primary @if ($bOpenSearch) active @endif">Search
            Dispatch</button>
        <div class="panel" @if ($bOpenSearch) style="display: block;" @endif>
            <div class="card shadow mb-4">
                <!--<div class="card-header py-3">
                                                                            <h6 class="m-0 font-weight-bold text-primary">Search Dispatch</h6>
                                                                        </div>-->
                <form method="GET" action="{{ route('dispatch.searchview') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                                <label for="datepicker_from" class="top_option">From: </label>
                                <input type="date" name="datepicker_from" value="{{ request()->datepicker_from }}"
                                    id="datepicker_from" class="form-control form-control-user" />
                            </div>
                            <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                                <label for="datepicker_to" class="top_option">To: </label>
                                <input type="date" name="datepicker_to" value="{{ request()->datepicker_to }}"
                                    id="datepicker_to" class="form-control form-control-user" />
                            </div>
                            <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                                <label for="completed" class="top_option">All Dates:</label>
                                <input type="checkbox" name="datepicker_all" id="datepicker_all"
                                    class="form-control form-control-user" <?php
                                    if (isset($_GET['datepicker_all']) && $_GET['datepicker_all'] != '') {
                                        echo 'checked';
                                    } ?> />
                            </div>

                            <!-- <div class="col-sm-3 mb-2 mt-6 mb-sm-0">
                                                                                    <label for="note" class="top_option" style="padding-bottom:20px;">note: </label>
                                                                                        <label class="switch" style="margin: 20px 0px -14px 100px;">
                                                                                            <input type="checkbox" name="note" id="note" class="form-control form-control-user">
                                                                                            <span class="slider round"></span>
                                                                                        </label>
                                                                                    </div> -->
                            {{-- <div class="col-sm-4 mb-2 mt-6 mb-sm-0">
                        <label for="completed" class="top_option" style="padding-bottom:20px;">Completed: </label>
                            <label class="switch"  style="margin: 20px 0px -14px 100px;">
                                <input type="checkbox" name="completed" id="completed" class="form-control form-control-user"<?php
                                // if(isset($_GET['completed']) && $_GET['completed'] != ''){
                                //     echo "checked";
                                // }
                                ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="col-sm-4 mb-2 mt-6 mb-sm-0" >
                        <label for="noship" class="top_option" style="padding-left:20px;">Ship: </label>
                            <label class="switch"  style="margin: 20px 0px -14px 100px;">
                                <input type="checkbox" name="noship" id="noship" class="form-control form-control-user"<?php
                                // if(isset($_GET['noship']) && $_GET['noship'] != ''){
                                //     echo "checked";
                                // }
                                ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="col-sm-4 mb-2 mt-6 mb-sm-0">
                        <label for="voided" class="top_option" style="padding-left:20px;;">VOID: </label>
                            <label class="switch"  style="margin: 20px 0px -14px 100px;">
                                <input type="checkbox" name="voided" id="voided" class="form-control form-control-user"<?php
                                // if(isset($_GET['voided']) && $_GET['voided'] != ''){
                                //     echo "checked";
                                // }
                                ?>>
                                <span class="slider round"></span>
                            </label>
                        </div> --}}


                            <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                                <label for="completed" class="top_option">Completed: </label>
                                <select name="completed" id="completed" class="form-control form-control-user">
                                    <option value="" selected="selected">Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                                <label for="noship" class="top_option">Ship: </label>
                                <select name="noship" id="noship" class="form-control form-control-user">
                                    <option value="" selected="selected">Select</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                                <label for="voided" class="top_option">Show Voided: </label>
                                <select name="voided" id="voided" class="form-control form-control-user">
                                    <option value="" selected="selected">Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                                <label for="id">ID:</label>
                                <input class="form-control form-control-user" type="text" name="id"
                                    value="<?php
                                    if (isset($_GET['id']) && $_GET['id'] != '') {
                                        echo $_GET['id'];
                                    } ?>" id="id" maxlength="50" size="50" />
                            </div>

                            <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                                <label for="release_code">Release Code:</label>
                                <input class="form-control form-control-user" type="text" name="release_code"
                                    value="<?php
                                    if (isset($_GET['release_code']) && $_GET['release_code'] != '') {
                                        echo $_GET['release_code'];
                                    } ?>" id="release_code" maxlength="50" size="50" />
                            </div>
                            <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                                <label for="purchase_code">Purchase Code:</label>
                                <input class="form-control form-control-user" type="text" name="purchase_code"
                                    value="<?php
                                    if (isset($_GET['purchase_code']) && $_GET['purchase_code'] != '') {
                                        echo $_GET['purchase_code'];
                                    } ?>" id="purchase_code" maxlength="50" size="50" />
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <label for="sales_num">Sales Number:</label>
                                <input class="form-control form-control-user" type="text" name="sales_num"
                                    value="<?php
                                    if (isset($_GET['sales_num']) && $_GET['sales_num'] != '') {
                                        echo $_GET['sales_num'];
                                    } ?>" id="sales_num" maxlength="50" size="50" />
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <label for="notes">Notes / Instructions:</label>
                                <input class="form-control form-control-user" type="text" name="notes"
                                    value="" id="notes" maxlength="100" size="100" />
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Commodity: </label>
                                <select id="commodity" name="commodity" class="form-control form-control-user">
                                    <option selected disabled>Select commodity</option>
                                    <?php $commodity = null;
                                    if (isset($_GET['commodity']) && $_GET['commodity'] != '') {
                                        $commodity = $_GET['commodity'];
                                    }
                                    ?>
                                    @foreach ($commodities->sortBy('name') as $commoditie)
                                        <option style="color:{{ $commoditie->id }}" value="{{ $commoditie->id }}"
                                            {{ $commoditie->id == $commodity ? 'selected' : '' }}>{{ $commoditie->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Via: </label>
                                <select id="via" name="via" class="form-control form-control-user">
                                    <option selected disabled>Select Via</option>
                                    <?php $via1 = null;
                                    
                                    if (isset($_GET['via']) && $_GET['via'] != '') {
                                        $via1 = $_GET['via'];
                                    }
                                    
                                    ?>
                                    @foreach ($vias->sortBy('name') as $via)
                                        <option value="{{ $via->id }}" {{ $via->id == $via1 ? 'selected' : '' }}>
                                            {{ $via->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Supplier: </label>
                                <select id="supplier" name="supplier" class="form-control form-control-user">
                                    <option selected disabled>Select Supplier</option>
                                    <?php $supplier1 = null;
                                    
                                    if (isset($_GET['supplier']) && $_GET['supplier'] != '') {
                                        $supplier1 = $_GET['supplier'];
                                    }
                                    
                                    ?>
                                    @foreach ($suppliers->sortBy('name') as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ $supplier->id == $supplier1 ? 'selected' : '' }}>{{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Destination</label>
                                <select id="destination" name="destination" class="form-control form-control-user">
                                    <option selected disabled>Select Destination</option>
                                    <?php $destination1 = null;
                                    
                                    if (isset($_GET['destination']) && $_GET['destination'] != '') {
                                        $destination1 = $_GET['destination'];
                                    }
                                    
                                    ?>
                                    @foreach ($destinations->sortBy('name') as $destination)
                                        <option value="{{ $destination->id }}"
                                            {{ $destination->id == $destination1 ? 'selected' : '' }}>
                                            {{ $destination->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Exit: </label>
                                <select id="exit" name="exit" class="form-control form-control-user">
                                    <option selected disabled>Select Exit</option>
                                    <?php $exit1 = null;
                                    
                                    if (isset($_GET['exit']) && $_GET['exit'] != '') {
                                        $exit1 = $_GET['exit'];
                                    }
                                    
                                    ?>
                                    @foreach ($exits->sortBy('name') as $exit)
                                        <option value="{{ $exit->id }}" {{ $exit->id == $exit1 ? 'selected' : '' }}>
                                            {{ $exit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Salesman: </label>
                                <select id="salesman" name="salesman" class="form-control form-control-user">
                                    <option selected disabled>Select Salesman</option>
                                    <?php $salesman = null;
                                    
                                    if (isset($_GET['salesman']) && $_GET['salesman'] != '') {
                                        $salesman = $_GET['salesman'];
                                    }
                                    
                                    ?>
                                    @foreach ($users->sortBy('first_name') as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == $salesman ? 'selected' : '' }}>{{ $user->first_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Rate: </label>
                                <select id="rate" name="rate" class="form-control form-control-user">
                                    <option selected disabled>Select Rate</option>
                                    <?php $rate1 = null;
                                    
                                    if (isset($_GET['rate']) && $_GET['rate'] != '') {
                                        $rate1 = $_GET['rate'];
                                    }
                                    
                                    ?>
                                    @foreach ($rates->sortBy('name') as $rate)
                                        <option value="{{ $rate->id }}" {{ $rate->id == $rate1 ? 'selected' : '' }}>
                                            {{ $rate->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-user float-right mb-3">Filter</button>
                        <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('home') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>



        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-hover table-bordered responsive" id="dataTable" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            {{-- <th></th> --}}
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

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dispatches as $dispatch)
                            <tr class="{{ $dispatch->release_code == '' ? 'table-info' : ' ' }}{{ $dispatch->noship == 1 ? 'table-danger' : ' ' }}{{ $dispatch->void == 1 ? 'table-dark' : ' ' }}{{ $dispatch->delivered == 1 ? 'table-success' : ' ' }}"
                                @if ($dispatch->void == 1) style="background-color: #D3D3D3; text-decoration: line-through;" @endif>
                                {{-- <td><input class="all-check" type="checkbox" value="{{ $dispatch->id }}"></td> --}}
                                <td>{!! date('m/d/Y', $dispatch?->date) !!}</td>
                                <?php /*<td>{!! $dispatch->id!!}</td>*/ ?>
                                <td style="color:{{ $dispatch->commodity?->color ?? '' }};font-weight: bold;">
                                    <span>{!! $dispatch->commodity?->name ?? $dispatch->commodity_id !!}</span>
                                </td>
                                <?php /*<td> {!! $dispatch->supplier->name ?? $dispatch->supplier_id!!}</td>
                                <td>{!! $dispatch->purchase_code ?? ' '!!}</td>*/
                                ?>
                                <td>{!! $dispatch->exit->name ?? $dispatch->exit_id !!}</td>
                                <td>{!! $dispatch->release_code ?? ' ' !!}</td>
                                <td><span>{!! $dispatch->via->name ?? $dispatch->via_id !!}</span>
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


    @include('dispatch.delete-modal')

    @include('dispatch.changelog')

@endsection

@section('scripts')
    @include('dispatch.js')
    <script>
        (function() {
            setTimeout(function() {
                var datepicker_from = document.getElementById('datepicker_from');
                var datepicker_to = document.getElementById('datepicker_to');
                datepicker_from.value = "{{ request()->datepicker_from }}"
                datepicker_to.value = "{{ request()->datepicker_to }}"
                console.log(datepicker_from)
                console.log(datepicker_to)
            }, 500)

        })();
    </script>
@endsection
