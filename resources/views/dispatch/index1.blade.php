@extends('layouts.app')

@section('title', 'Dispatch')

@push('styles')
    {{-- <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css" /> --}}
    {{-- <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" /> --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.2/css/jquery.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 42px !important;
        }
    </style>
@endpush
@section('content')

    <?php
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
    } else {
        $date = date('m/d/Y');
    }
    ?>

    {{-- Breadcrumbs --}}
    @include('common.breadcrumbs', ['title' => 'Dispatch'])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            {{-- daily view --}}
            <div class="d-flex align-items-center justify-content-between collapsible py-3 toggle @if ($bOpenSearch) collapsed @endif mb-0"
                data-bs-toggle="collapse" data-bs-target="#dailyView">
                <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">Daily View</h4>
                <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                    <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <i class="ki-duotone ki-plus-square toggle-off fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                </div>
            </div>

            <div id="dailyView" class="collapse @if (!$bOpenSearch) show @endif fs-6 ms-1">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="col-md-12 mb-3 mt-3 mb-sm-0" style="text-align:center">
                            <a href="{{ route('dispatch.searchview', ['date' => date('m/d/Y', strtotime($date . ' -1 day'))]) }}"
                                class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i></a>
                            <input class="btn btn-sm btn-primary" type="date" name="date" id="date_view"
                                value="<?php echo isset($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : date('Y-m-d'); ?>">
                            <!--<input  class="btn btn-sm btn-primary" type="date" name="date" id="date_view" value="<?php echo isset($_GET['date']) ? date('Y-m-d', strtotime($date . ' +1 day')) : date('Y-m-d', strtotime($date . ' +1 day')); ?>">-->
                            <a href="{{ route('dispatch.searchview', ['date' => date('m/d/Y', strtotime($date . ' +1 day'))]) }}"
                                class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i></a>
                            <div class="d-flex justify-content-end">
                                <div class="me-2" style="width:15%;">
                                    @php
                                        $display_notes = session('display_notes') ?? 'show';
                                    @endphp

                                    <label>Notes</label>
                                    <select class="form form-select" name="display_notes" id="display_notes"
                                        onchange="ChangeNotesDisplay()">
                                        <option value="show" @if ($display_notes == 'show') selected @endif>Show
                                        </option>
                                        <option value="hide" @if ($display_notes == 'hide') selected @endif>Hide
                                        </option>
                                    </select>
                                </div>

                                <div style="width:15%;">
                                    @php
                                        $changedisplay = session('changedisplay');
                                    @endphp

                                    <label>Display</label>
                                    <select class="form form-select" name="dispatch_display"
                                        onchange="ChangeDisptachDisplay()" id="dispatch_display">
                                        <option value="completed" @if ($changedisplay == 'completed') selected @endif>
                                            Completed
                                        </option>
                                        <option value="open" @if ($changedisplay == 'open') selected @endif>Open
                                        </option>
                                        <option value="ship" @if ($changedisplay == 'ship') selected @endif>Ready to
                                            Ship
                                        </option>
                                        <option value="noship" @if ($changedisplay == 'noship') selected @endif>NO Ship
                                        </option>
                                        <option value="void" @if ($changedisplay == 'void') selected @endif>Void
                                        </option>
                                        <option value="all" @if ($changedisplay == 'all') selected @endif>ALL
                                        </option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- daily view end --}}

            {{-- Search Dispatch --}}
            <div class="d-flex align-items-center justify-content-between collapsible py-3 toggle collapsed @if ($bOpenSearch) collapsed @endif mb-0"
                data-bs-toggle="collapse" data-bs-target="#searchDispatch">
                <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">Search Dispatch</h4>
                <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                    <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <i class="ki-duotone ki-plus-square toggle-off fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                </div>
            </div>

            <div id="searchDispatch" class="collapse @if ($bOpenSearch) show @endif fs-6 ms-1">
                <div class="card shadow mb-4">
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
                                <div
                                    class="col-sm-4 mb-2 mt-2 mb-sm-0 d-flex justify-content-center align-items-center gap-3">
                                    <label for="completed" class="top_option">All Dates:</label>
                                    <input type="checkbox" name="datepicker_all" id="datepicker_all"
                                        class="form-check-input" <?php
                                        if (isset($_GET['datepicker_all']) && $_GET['datepicker_all'] != '') {
                                            echo 'checked';
                                        } ?> />
                                </div>

                                <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                                    <label for="completed" class="top_option">Completed: </label>
                                    <select name="completed" id="completed" class="form-select">
                                        <option value="" selected="selected">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>

                                <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                                    <label for="noship" class="top_option">Ship: </label>
                                    <select name="noship" id="noship" class="form-select">
                                        <option value="" selected="selected">Select</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                                    <label for="voided" class="top_option">Show Voided: </label>
                                    <select name="voided" id="voided" class="form-select">
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
                                    <select id="commodity" name="commodity" class="form-select">
                                        <option selected disabled>Select commodity</option>
                                        <?php $commodity = null;
                                        if (isset($_GET['commodity']) && $_GET['commodity'] != '') {
                                            $commodity = $_GET['commodity'];
                                        }
                                        ?>
                                        @foreach ($commodities->sortBy('name') as $commoditie)
                                            <option style="color:{{ $commoditie->id }}" value="{{ $commoditie->id }}"
                                                {{ $commoditie->id == $commodity ? 'selected' : '' }}>
                                                {{ $commoditie->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                    Via: </label>
                                    <select id="via" name="via" class="form-select">
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
                                </div>
                                <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                    Supplier: </label>
                                    <select id="supplier" name="supplier" class="form-select">
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
                                    <select id="destination" name="destination" class="form-select">
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
                                    <select id="exit" name="exit" class="form-select">
                                        <option selected disabled>Select Exit</option>
                                        <?php $exit1 = null;
                                        
                                        if (isset($_GET['exit']) && $_GET['exit'] != '') {
                                            $exit1 = $_GET['exit'];
                                        }
                                        
                                        ?>
                                        @foreach ($exits->sortBy('name') as $exit)
                                            <option value="{{ $exit->id }}"
                                                {{ $exit->id == $exit1 ? 'selected' : '' }}>
                                                {{ $exit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 row">
                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                        Salesman: </label>
                                        <select id="salesman" name="salesman" class="form-select">
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
                                        <select id="rate" name="rate" class="form-select">
                                            <option selected disabled>Select Rate</option>
                                            <?php $rate1 = null;
                                            
                                            if (isset($_GET['rate']) && $_GET['rate'] != '') {
                                                $rate1 = $_GET['rate'];
                                            }
                                            
                                            ?>
                                            @foreach ($rates->sortBy('name') as $rate)
                                                <option value="{{ $rate->id }}"
                                                    {{ $rate->id == $rate1 ? 'selected' : '' }}>
                                                    {{ $rate->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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
            {{-- Search Dispatch End --}}


            <div class="card shadow">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <div class="">
                        <a href="javascript:void(0)" onclick="BulkEdit()" class="btn btn-sm btn-primary">
                            <i class="fas fa-check"></i>Bulk Edit
                        </a>
                        <a class="btn btn-sm btn-primary" href="#" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>
                    @php
                        $view = request()->view ?? 'all';
                    @endphp
                    @if (Auth::user()->hasRole('Admin'))
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <button type="button"
                                class="btn btn-sm {{ $view === 'all' ? 'btn-primary' : 'btn-outline-primary' }} view-btn"
                                data-view="all">All</button>
                            <button type="button"
                                class="btn btn-sm {{ $view === 'trucks' ? 'btn-primary' : 'btn-outline-primary' }} view-btn"
                                data-view="trucks">Trucks</button>
                            <button type="button"
                                class="btn btn-sm {{ $view === 'suppliers' ? 'btn-primary' : 'btn-outline-primary' }} view-btn"
                                data-view="suppliers">Suppliers</button>
                        </div>
                    @endif
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-hover table-bordered" width="100%" cellspacing="0">
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
                                    @else
                                        @if ($view === 'all')
                                            <th></th>
                                        @endif
                                        <th>Date</th>
                                        @if ($view === 'all')
                                            <th>Id</th>
                                        @endif
                                        <th data-priority="1">Commodity</th>

                                        @if ($view !== 'suppliers')
                                            <th>Supplier</th>
                                        @endif

                                        @if ($view === 'all')
                                            <th>Purchase Code</th>
                                        @endif
                                        @if ($view !== 'suppliers')
                                            <th>Exit</th>
                                        @endif
                                        <th>Release Code</th>
                                        <th data-priority="2">Via</th>
                                        @if ($view !== 'suppliers')
                                            <th data-priority="3">Destination</th>
                                        @endif
                                        @if ($view !== 'suppliers')
                                            <th>Rate</th>
                                        @endif
                                        @if ($view === 'all')
                                            <th>Saleman</th>
                                            <th>Sales No.</th>
                                            @if ($display_notes === 'show')
                                                <th class="d-none">Driver Note</th>
                                                <th class="d-none">Sale Note</th>
                                                <th class="d-none">Account Note</th>
                                            @endif
                                            <th>Status</th>
                                        @endif


                                        @if ($view === 'trucks')
                                            <th class="d-none">Driver Note</th>
                                        @endif
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dispatches as $dispatch)
                                    <tr class="{{ $dispatch->release_code == '' ? 'table-info' : ' ' }}{{ $dispatch->noship == 1 ? 'table-danger' : ' ' }}{{ $dispatch->void == 1 ? 'table-dark' : ' ' }}{{ $dispatch->delivered == 1 ? 'table-success' : ' ' }}"
                                        @if ($dispatch->void == 1) style="background-color: #D3D3D3; text-decoration: line-through;" @endif>
                                        @if (Auth::user()->hasRole('salesman'))
                                            <td><input class="all-check" type="checkbox" value="{{ $dispatch->id }}">
                                            </td>
                                            <td onclick="EditDispatch({{ $dispatch->id }})">{!! date('m/d/Y', $dispatch?->date) !!}</td>
                                            <?php /*<td onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->id!!}</td>*/ ?>
                                            <td style="color:{{ $dispatch->commodity?->color ?? '' }};font-weight: bold;">
                                                <span
                                                    onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->commodity?->name ?? $dispatch->commodity_id !!}</span>
                                            </td>
                                            <?php /*<td onclick="EditDispatch({{ $dispatch->id }})"> {!! $dispatch->supplier->name ?? $dispatch->supplier_id!!}</td>
                        <td onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->purchase_code ?? ' '!!}</td>*/
                                            ?>
                                            <td onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->exit->name ?? $dispatch->exit_id !!}</td>
                                            <td onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->release_code ?? ' ' !!}</td>
                                            <td><span
                                                    onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->via->name ?? $dispatch->via_id !!}</span>
                                            </td>
                                            <td><span
                                                    onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->destination?->name ?? $dispatch->destination_id !!}<br>{!! $dispatch->destination?->address !!}</span>
                                            </td>
                                            <td onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->rate->name ?? $dispatch->rate_id !!}</td>
                                        @else
                                            @if ($view === 'all')
                                                <?php
                                                $strDispClass = '';
                                                $strHiddenFields = '';
                                                if ($config[7]->value == 'show') {
                                                    if ($dispatch->driver_instructions != '') {
                                                        $strDispClass = 'class="details-control"';
                                                        $strHiddenFields = $strHiddenFields . '<input type="hidden" class="driver_instructions" value="' . $dispatch->driver_instructions . '" />';
                                                    }
                                                    if ($dispatch->sales_notes != '') {
                                                        $strDispClass = 'class="details-control"';
                                                        $strHiddenFields = $strHiddenFields . '<input type="hidden" class="sales_notes" value="' . $dispatch->sales_notes . '" />';
                                                    }
                                                    if ($dispatch->accounting_notes != '') {
                                                        $strDispClass = 'class="details-control"';
                                                        $strHiddenFields = $strHiddenFields . '<input type="hidden" class="accounting_notes" value="' . $dispatch->accounting_notes . '" />';
                                                    }
                                                }
                                                ?>
                                                {{-- <?php echo $display_notes === 'hide' ? $strDispClass : ''; ?> --}}
                                                <td><input class="all-check" type="checkbox"
                                                        value="{{ $dispatch->id }}"><?php echo $strHiddenFields; ?></td>
                                            @endif
                                            <td onclick="EditDispatch({{ $dispatch->id }})">{!! date('m/d/Y', $dispatch->date) !!}</td>
                                            @if ($view === 'all')
                                                <td onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->id !!}
                                                </td>
                                            @endif
                                            <td style="color:{{ $dispatch->commodity->color ?? '' }};font-weight: bold;">
                                                <span
                                                    onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->commodity->name ?? $dispatch->commodity_id !!}</span>
                                            </td>

                                            @if ($view !== 'suppliers')
                                                <td onclick="EditDispatch({{ $dispatch->id }})"> {!! $dispatch->supplier->name ?? $dispatch->supplier_id !!}
                                                </td>
                                            @endif
                                            @if ($view === 'all')
                                                <td onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->purchase_code ?? ' ' !!}
                                                </td>
                                            @endif
                                            @if ($view !== 'suppliers')
                                                <td onclick="EditDispatch({{ $dispatch->id }})">
                                                    {!! $dispatch->exit->name ?? $dispatch->exit_id !!}
                                                </td>
                                            @endif
                                            <td onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->release_code ?? ' ' !!}</td>
                                            <td><span
                                                    onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->via->name ?? $dispatch->via_id !!}</span>
                                            </td>
                                            @if ($view !== 'suppliers')
                                                <td><span
                                                        onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->destination?->name ?? $dispatch->destination_id !!}<br>{!! $dispatch->destination?->address !!}</span>
                                                </td>
                                            @endif
                                            @if ($view !== 'suppliers')
                                                <td onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->rate->name ?? $dispatch->rate_id !!}
                                                </td>
                                            @endif
                                            @if ($view === 'all')
                                                <td onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->salesman1->first_name ?? ' ' !!}
                                                </td>
                                                <td onclick="EditDispatch({{ $dispatch->id }})">{!! $dispatch->sales_num ?? ' ' !!}
                                                </td>
                                                @if ($display_notes === 'show')
                                                    <td class="d-none">{{ $dispatch->driver_instructions }}</td>
                                                    <td class="d-none">{{ $dispatch->sales_notes }}</td>
                                                    <td class="d-none">{{ $dispatch->accounting_notes }}</td>
                                                @endif
                                                <td>
                                                    @if ($dispatch->delivered)
                                                        <span class="badge badge-success">Loaded</span>
                                                    @else
                                                        <span class="badge badge-warning">Not Loaded</span>
                                                    @endif
                                                </td>
                                            @endif


                                            @if ($view === 'trucks')
                                                <td class="d-none">{{ $dispatch->driver_instructions }}</td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
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

@push('scripts')
    @include('dispatch.js')
    <script>
        (function() {
            setTimeout(function() {
                var datepicker_from = document.getElementById('datepicker_from');
                var datepicker_to = document.getElementById('datepicker_to');
                datepicker_from.value = "{{ request()->datepicker_from }}"
                datepicker_to.value = "{{ request()->datepicker_to }}"
            }, 500)

        })();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#commodity').select2();
            $('#via').select2();
            $('#supplier').select2();
            $('#destination').select2();
            $('#exit').select2();
            $('#salesman').select2();
            $('#rate').select2();
        });
    </script>
@endpush
