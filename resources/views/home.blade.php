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
        <div class="col-md-12">
            <h2 class="text-center mb-3">Dispatch v1.2 - 01/30/2023</h2>
            <p><b>Changes Log:</b></p>
            <ul>
                <li>Dispatch Table fonts darkened for visibility.</li>
                <li>Search Page returns correct results.</li>
                <li>Duplicate release code entries are no longer possible with validation.</li>
                <li>Date Picker now functions properly on dispatch page.</li>
            </ul>
            <p><b>In Progress:</b></p>
            <ul>
                <li>Aesthetics<br />
                    Images / Logo<br />
                    Credits<br />
                    Login Page</li>
                <li>Voided records - Strikethrough & Grey</li>
                <li>Rem Card Header Row</li>
                <li>Add Sales Number to Bulk Edit Modal</li>
                <li>Add Purchase Number to Bulk Edit Modal</li>
                <li>Cannot Bulk Edit rows with incomplete information - error missing < name > in fields - add null item to every table?</li>
                <li>SEARCH - on Load query current day by default</li>
                <li>SEARCH - Remove Select All dates entirely.</li>
                <li>Add Truck/Supplier button group to Search Page</li>
                <li>Replace Text Links with BS button Group</li>
                <li>Add Suffix to Release Number - AUTO</li>
                <li>Driver Portal (BETA)</li>
                <li>Dashboard - Today's loads - commodity, destination, via</li>
                <li>Dashboard - Loads attributed to sales/via users only</li>
                <li>Dashboard - Stats</li>
                <li>Test Dispatch - Search unification w/ accordion fields</li>
            </ul>
        </div>
    </div>

    <!-- Content Row -->
    <!-- <div class="row">

        <!-- Earnings (Monthly) Card Example 
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Earnings (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example 
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Earnings (Annual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example 
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example 
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    

</div>
@endsection