@extends('layouts.app')

@section('title', 'Freight Calculator')
@push('styles')
    @include('freight.style')
@endpush

@section('content')
    @include('common.breadcrumbs', [
        'title' => 'Freight Calculator',
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <!----- Select Exit and Destination--->
            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">Freight Calculator</h6>
                </div>

                <div class="card-body">
                    <form action="" id="geoForm">
                        <div class="row">
                            {{-- Exit --}}
                            <div class="col-12">
                                <div id="error" class="alert alert-danger d-none"></div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <div class="form-group">
                                            <label>Select Exit</label>
                                            <select id="exit" class="form-select">
                                                <option selected disabled value="">Select Exit</option>
                                                @foreach ($exits->sortBy('name') as $exit)
                                                    <option value="{{ $exit->address }}">{!! $exit->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <strong>OR</strong>
                                    </div>
                                    <div class="col-12 mb-6">
                                        <div class="form-group">
                                            <label>Enter Exit Address</label>
                                            <input type="text" class="form-control map-input" id="exitAddress"
                                                placeholder="13646 Ca-33, Lost Hills, CA Gate #2" name="address">
                                            <input type="hidden" name="exit" value="">
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- Destination --}}
                            <div class="col-md-6 mb-6">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <div class="form-group">
                                            <label>Select Destination</label>
                                            <select id="destination" class="form-select">
                                                <option selected disabled value="">Select Destination</option>
                                                @foreach ($destinations->sortBy('name') as $destination)
                                                    <option value="{{ $destination->address }}">{!! $destination->name !!}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <strong>OR</strong>
                                    </div>
                                    <div class="col-12 mb-6">
                                        <div class="form-group">
                                            <label>Enter Destination Address</label>
                                            <input type="text" class="form-control map-input" id="destinationAddress"
                                                placeholder="13646 Ca-33, Lost Hills, CA Gate #2">
                                            <input type="hidden" name="destination" value="">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!----- Showing Result--->
            <div class="row mt-10">
                <div class="col-md-3 mb-5">
                    <h5>Mileage</h5>
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h1 id="mileage" style="font-size: 30px;">0</h1>
                                <h5 class="text-muted ps-3 pt-3">Miles</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-5">
                    <h5>Suggested Local Rate</h5>
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h1 id="suggestedRate" style="font-size: 30px;">$0</h1>
                                <h5 class="text-muted ps-3 pt-3">Per Ton</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-5">
                    <h5>Suggested Local Shell Rate</h5>
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h1 id="shellRate" style="font-size: 30px;">$0</h1>
                                <h5 class="text-muted ps-3 pt-3">Per Ton</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-5">
                    <h5>Minimum Long Distance Rate</h5>
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h1 id="longDistanceRate" style="font-size: 30px;">$0</h1>
                                <h5 class="text-muted ps-3 pt-3">Per Ton</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!----- Showing Result--->
            <div class="card shadow mt-10">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">Map View</h6>
                </div>
                <div class="card-body">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border text-primary" style="width: 6rem; height: 6rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h2 class="pt-5 text-primary">Please Wait</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade d-none" id="loadingBackdrop"></div>
@endsection
@push('scripts')
    @include('freight.js')
@endpush
