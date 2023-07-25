@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 42px !important;
        }
    </style>
@endpush
@section('title', 'Add Truck')

@section('content')

    @include('common.breadcrumbs', [
        'title' => 'Add Truck',
        'btn_text' => 'Back',
        'btn_link' => route('via.index'),
    ])

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">Add New Truck</h6>
                </div>

                <form method="POST" action="{{ route('via.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">

                            {{-- Company Name --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>Company Name</label>
                                <input type="text"
                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                    id="exampleName" placeholder="***Company Name***" name="name"
                                    value="{{ old('name') }}">

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Contact Name --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>Contact Name</label>
                                <input type="text"
                                    class="form-control form-control-user @error('contact_name') is-invalid @enderror"
                                    id="exampleContactName" placeholder="***Contact Name***" name="contact_name"
                                    value="{{ old('contact_name') }}">

                                @error('contact_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Email Address --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>Email Address</label>
                                <input type="email"
                                    class="form-control form-control-user @error('email') is-invalid @enderror"
                                    id="exampleEmail" placeholder="***Email Address***" name="email"
                                    value="{{ old('email') }}">

                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Phone Number --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>Phone Number</label>
                                <input type="tel"
                                    class="form-control form-control-user @error('phone') is-invalid @enderror"
                                    id="examplePhone" placeholder="***Phone Number***" name="phone"
                                    value="{{ old('phone') }}">

                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Number of trucks --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>Number of Trucks</label>
                                <input type="number"
                                    class="form-control form-control-user @error('trucks') is-invalid @enderror"
                                    id="exampleTrucks" placeholder="***Number of Trucks***" name="trucks"
                                    value="{{ old('trucks') }}">

                                @error('trucks')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Equipment Type --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>Equipment Type</label>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="equip_type[]" type="checkbox"
                                        value="Walking Floor" id="WalkingFloor" @checked(in_array('Walking Floor', old('equip_type', [])))>
                                    <label class="form-check-label" for="WalkingFloor" style="padding-top: 2px;">
                                        Walking Floor
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="equip_type[]" type="checkbox" value="Belt"
                                        id="Belt" @checked(in_array('Belt', old('equip_type', [])))>
                                    <label class="form-check-label" for="Belt" style="padding-top: 2px;">
                                        Belt
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="equip_type[]" type="checkbox" value="Hopper"
                                        id="Hopper" @checked(in_array('Hopper', old('equip_type', [])))>
                                    <label class="form-check-label" for="Hopper" style="padding-top: 2px;">
                                        Hopper
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="equip_type[]" type="checkbox" value="Doubles"
                                        id="Doubles" @checked(in_array('Doubles', old('equip_type', [])))>
                                    <label class="form-check-label" for="Doubles" style="padding-top: 2px;">
                                        Doubles
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="equip_type[]" type="checkbox" value="Low-side"
                                        id="Low-side" @checked(in_array('Low-side', old('equip_type', [])))>
                                    <label class="form-check-label" for="Low-side" style="padding-top: 2px;">
                                        Low-side
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="equip_type[]" type="checkbox" value="Dump"
                                        id="Dump" @checked(in_array('Dump', old('equip_type', [])))>
                                    <label class="form-check-label" for="Dump" style="padding-top: 2px;">
                                        Dump
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="equip_type[]" type="checkbox" value="Curtain"
                                        id="Curtain" @checked(in_array('Curtain', old('equip_type', [])))>
                                    <label class="form-check-label" for="Curtain" style="padding-top: 2px;">
                                        Curtain
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="equip_type[]" type="checkbox" value="Reefer"
                                        id="Reefer" @checked(in_array('Reefer', old('equip_type', [])))>
                                    <label class="form-check-label" for="Reefer" style="padding-top: 2px;">
                                        Reefer
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="equip_type[]" type="checkbox" value="Dry Van"
                                        id="Dry-Van" @checked(in_array('Dry Van', old('equip_type', [])))>
                                    <label class="form-check-label" for="Dry-Van" style="padding-top: 2px;">
                                        Dry Van
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="equip_type[]" type="checkbox" value="Flatbed"
                                        id="Flatbed" @checked(in_array('Flatbed', old('equip_type', [])))>
                                    <label class="form-check-label" for="Flatbed" style="padding-top: 2px;">
                                        Flatbed
                                    </label>
                                </div>

                                @error('equip_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Service Area --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>Service Area</label>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="service_area[]" type="checkbox" value="HTV"
                                        id="HTV" @checked(in_array('HTV', old('service_area', [])))>
                                    <label class="form-check-label" for="HTV" style="padding-top: 2px;">
                                        HTV
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="service_area[]" type="checkbox" value="MOT"
                                        id="MOT" @checked(in_array('MOT', old('service_area', [])))>
                                    <label class="form-check-label" for="MOT" style="padding-top: 2px;">
                                        MOT
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="service_area[]" type="checkbox" value="KERN"
                                        id="KERN" @checked(in_array('KERN', old('service_area', [])))>
                                    <label class="form-check-label" for="KERN" style="padding-top: 2px;">
                                        KERN
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="service_area[]" type="checkbox" value="NORCAL"
                                        id="NORCAL" @checked(in_array('NORCAL', old('service_area', [])))>
                                    <label class="form-check-label" for="NORCAL" style="padding-top: 2px;">
                                        NORCAL
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="service_area[]" type="checkbox" value="SOCAL"
                                        id="SOCAL" @checked(in_array('SOCAL', old('service_area', [])))>
                                    <label class="form-check-label" for="SOCAL" style="padding-top: 2px;">
                                        SOCAL
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="service_area[]" type="checkbox" value="OTR"
                                        id="OTR" @checked(in_array('OTR', old('service_area', [])))>
                                    <label class="form-check-label" for="OTR" style="padding-top: 2px;">
                                        OTR
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="service_area[]" type="checkbox" value="FOB"
                                        id="FOB" @checked(in_array('FOB', old('service_area', [])))>
                                    <label class="form-check-label" for="FOB" style="padding-top: 2px;">
                                        FOB
                                    </label>
                                </div>

                                @error('service_area')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Link User --}}
                            <div class="col-sm-12 mb-6">
                                <label><span style="color:red;">*</span>Link User</label>
                                <select id="user" class="form-select @error('user_id') is-invalid @enderror"
                                    name="user_id">
                                    <option selected disabled>Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                            {{ $user->full_name . ' (' . $user->email . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-sm-12 mb-6">
                                <span style="color:red;">*</span>Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="active">
                                    <option selected disabled>Select Status</option>
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-user float-right mb-6">Save</button>
                        <a class="btn btn-primary float-right mr-3 mb-6" href="{{ route('via.index') }}">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user').select2();
        });
    </script>
@endpush
