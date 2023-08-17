@extends('layouts.app')

@section('title', 'Config Setting')

@section('content')
    @include('common.breadcrumbs', ['title' => 'Config'])
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="card shadow mb-4">
                <div class="card-header card-header-height d-flex align-items-center">
                    <h6 class="font-weight-bold text-primary mb-0 pb-0">All Configs</h6>
                </div>

                <form method="POST" action="{{ route('config.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Mailing Address:</label>
                                <input class="form-control" type="text" name="mailing_address"
                                    value="{{ $config[0]['value'] }}" id="mailing_address" maxlength="100" size="100" />
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Default records per page:</label>
                                <select class="form-select" name="records_per_page">
                                    <option value="20" {{ $config['1']['value'] == 20 ? 'selected' : '' }}>20
                                    </option>
                                    <option value="50" {{ $config['1']['value'] == 50 ? 'selected' : '' }}>50
                                    </option>
                                    <option value="100" {{ $config['1']['value'] == 100 ? 'selected' : '' }}>100
                                    </option>
                                    <option value="99999999" {{ $config['1']['value'] == 99999999 ? 'selected' : '' }}>
                                        ALL</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Default notes:</label>
                                <select class="form-select" name="default_display_notes">
                                    <option value="show" {{ $config['7']['value'] == 'show' ? 'selected' : '' }}>Show
                                    </option>
                                    <option value="hide" {{ $config['7']['value'] == 'hide' ? 'selected' : '' }}>Hide
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Default display group:</label>
                                <select class="form-select" name="default_display">
                                    <option value="completed" {{ $config['4']['value'] == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="open" {{ $config['4']['value'] == 'open' ? 'selected' : '' }}>Open
                                    </option>
                                    <option value="ship" {{ $config['4']['value'] == 'ship' ? 'selected' : '' }}>
                                        Ready to Ship</option>
                                    <option value="noship" {{ $config['4']['value'] == 'noship' ? 'selected' : '' }}>NO
                                        Ship</option>
                                    <option value="void" {{ $config['4']['value'] == 'void' ? 'selected' : '' }}>Void
                                    </option>
                                    <option value="all" {{ $config['4']['value'] == 'all' ? 'selected' : '' }}>ALL
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Window auto close time (sec):</label>
                                <select class="form-select" name="window_auto_close">
                                    <option value="1" {{ $config['5']['value'] == 1 ? 'selected' : '' }}>1
                                    </option>
                                    <option value="2" {{ $config['5']['value'] == 2 ? 'selected' : '' }}>2
                                    </option>
                                    <option value="3" {{ $config['5']['value'] == 3 ? 'selected' : '' }}>3
                                    </option>
                                    <option value="4" {{ $config['5']['value'] == 4 ? 'selected' : '' }}>4
                                    </option>
                                    <option value="5" {{ $config['5']['value'] == 5 ? 'selected' : '' }}>5
                                    </option>
                                    <option value="10" {{ $config['5']['value'] == 10 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="15" {{ $config['5']['value'] == 15 ? 'selected' : '' }}>15
                                    </option>
                                    <option value="30" {{ $config['5']['value'] == 30 ? 'selected' : '' }}>30
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Auto refresh parent window on new/edit record:</label>
                                <select class="form-select" name="auto_refreash_win_on_new">
                                    <option value="1" {{ $config['6']['value'] == 1 ? 'selected' : '' }}>Yes
                                    </option>
                                    <option value="0" {{ $config['6']['value'] == 0 ? 'selected' : '' }}>No
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Allow multi login with same username:</label>
                                <select class="form-select" name="multi_sess_per_user">
                                    <option value="1" {{ $config['9']['value'] == 1 ? 'selected' : '' }}>Yes
                                    </option>
                                    <option value="0" {{ $config['9']['value'] == 0 ? 'selected' : '' }}>No
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Allowed session time (hr):</label>
                                <select class="form-select" name="sess_expiration">
                                    <option value="1" {{ $config['8']['value'] == 1 ? 'selected' : '' }}>1
                                    </option>
                                    <option value="2" {{ $config['8']['value'] == 2 ? 'selected' : '' }}>2
                                    </option>
                                    <option value="3" {{ $config['8']['value'] == 3 ? 'selected' : '' }}>3
                                    </option>
                                    <option value="4" {{ $config['8']['value'] == 4 ? 'selected' : '' }}>4
                                    </option>
                                    <option value="5" {{ $config['8']['value'] == 5 ? 'selected' : '' }}>5
                                    </option>
                                    <option value="6" {{ $config['8']['value'] == 6 ? 'selected' : '' }}>6
                                    </option>
                                    <option value="7" {{ $config['8']['value'] == 7 ? 'selected' : '' }}>7
                                    </option>
                                    <option value="8" {{ $config['8']['value'] == 8 ? 'selected' : '' }}>8
                                    </option>
                                    <option value="9" {{ $config['8']['value'] == 9 ? 'selected' : '' }}>9
                                    </option>
                                    <option value="10" {{ $config['8']['value'] == 10 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="11" {{ $config['8']['value'] == 11 ? 'selected' : '' }}>11
                                    </option>
                                    <option value="12" {{ $config['8']['value'] == 12 ? 'selected' : '' }}>12
                                    </option>
                                    <option value="13" {{ $config['8']['value'] == 13 ? 'selected' : '' }}>13
                                    </option>
                                    <option value="14" {{ $config['8']['value'] == 14 ? 'selected' : '' }}>14
                                    </option>
                                    <option value="15" {{ $config['8']['value'] == 15 ? 'selected' : '' }}>15
                                    </option>
                                    <option value="16" {{ $config['8']['value'] == 16 ? 'selected' : '' }}>16
                                    </option>
                                    <option value="17" {{ $config['8']['value'] == 17 ? 'selected' : '' }}>17
                                    </option>
                                    <option value="18" {{ $config['8']['value'] == 18 ? 'selected' : '' }}>18
                                    </option>
                                    <option value="19" {{ $config['8']['value'] == 19 ? 'selected' : '' }}>19
                                    </option>
                                    <option value="20" {{ $config['8']['value'] == 20 ? 'selected' : '' }}>20
                                    </option>
                                    <option value="21" {{ $config['8']['value'] == 21 ? 'selected' : '' }}>21
                                    </option>
                                    <option value="22" {{ $config['8']['value'] == 22 ? 'selected' : '' }}>22
                                    </option>
                                    <option value="23" {{ $config['8']['value'] == 23 ? 'selected' : '' }}>23
                                    </option>
                                    <option value="24" {{ $config['8']['value'] == 24 ? 'selected' : '' }}>24
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Allow remote access (global):</label>
                                <select class="form-select" name="remote_access">
                                    <option value="1" {{ $config['11']['value'] == 1 ? 'selected' : '' }}>Yes
                                    </option>
                                    <option value="0" {{ $config['11']['value'] == 0 ? 'selected' : '' }}>No
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                1 Ton:</label>
                                <input class="form-control" type="number" name="ton"
                                    value="{{ $config[12]['value'] }}" placeholder="1 Ton contains loads" />
                                @error('ton')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                Shell:</label>
                                <input class="form-control" type="text" name="shell"
                                    value="{{ $config[13]['value'] }}" placeholder="Shell Value" />
                                @error('shell')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                OHD:</label>
                                <input class="form-control" type="text" name="ohd"
                                    value="{{ $config[14]['value'] }}" placeholder="OHD Value" />
                                @error('ohd')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer col-sm-12 mb-6 mt-6 mb-sm-0">
                        <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                        <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('config.index') }}">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
@endpush
