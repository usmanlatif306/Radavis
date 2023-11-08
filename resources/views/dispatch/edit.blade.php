<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">Edit Dispatch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmEdit" method="POST" action="{{ route('dispatch.update') }}">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" class="form-control form-control-user" id="dispatch" name="dispatch_id"
                        value="">
                    <div class="form-group row">

                        {{-- Date --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Date</label>
                            <input type="date"
                                class="form-control form-control-user @error('date') is-invalid @enderror"
                                id="editdate" name="date" value="{{ old('date') }}">

                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Commodity --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Commodity</label>
                            <select id="edit-commoditie" onchange="EditUpdateSuppliers()"
                                class="form-select @error('commodity') is-invalid @enderror" name="commodity_id">
                                <option selected disabled>Select Commodity</option>
                                @foreach ($commodities->sortBy('name') as $commoditie)
                                    <option style="color:{{ $commoditie->color }}" value="{{ $commoditie->id }}">
                                        {{ $commoditie->name }}</option>
                                @endforeach
                            </select>

                            @error('commodity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Supplier --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Supplier</label>
                            <select id="edit-supplier" onchange="EditUpdateexits()"
                                class="form-select @error('supplier') is-invalid @enderror" name="supplier_id"
                                @if (Auth::user()->hasRole('salesman')) disabled="disabled" @endif>
                                <option selected="selected" disabled="disabled">Select Supplier</option>
                            </select>

                            @error('supplier')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Purchase Code --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Purchase Code</label>
                            <input type="text"
                                class="form-control form-control-user @error('PurchaseCode') is-invalid @enderror"
                                id="editpurchasecode" name="purchase_code" value="{{ old('PurchaseCode') }}"
                                @if (Auth::user()->hasRole('salesman')) disabled="disabled" @endif>

                            @error('PurchaseCode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Exits --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Exits</label>
                            <select id="edit-exits" class="form-select @error('exit') is-invalid @enderror"
                                name="exit_id" @if (Auth::user()->hasRole('salesman')) disabled="disabled" @endif>
                                <option selected="selected" disabled="disabled">Select Exits</option>
                            </select>

                            @error('exit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Release Code --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <!--<span style="color:red;">*</span>-->Release Code</label>
                            <input type="text"
                                class="form-control form-control-user @error('PurchaseCode') is-invalid @enderror"
                                id="editreleasecode" placeholder="Release Number" name="release_code"
                                value="{{ old('PurchaseCode') }}"
                                @if (Auth::user()->hasRole('salesman')) disabled="disabled" @endif>

                            @error('PurchaseCode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Via --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Via</label>
                            <select id="edit-via" class="form-select @error('via') is-invalid @enderror" name="via_id"
                                @if (Auth::user()->hasRole('salesman')) disabled="disabled" @endif>
                                <option selected disabled>Select Via</option>
                                @foreach ($vias->sortBy('name') as $via)
                                    <option value="{{ $via->id }}">{{ $via->name }}</option>
                                @endforeach
                            </select>
                            @error('via')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Destination --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Destination</label>
                            <select id="edit-destination" class="form-select @error('destination') is-invalid @enderror"
                                name="destination_id">
                                <option disabled>Select Destination</option>
                                @foreach ($destinations->sortBy('name') as $destination)
                                    <option value="{{ $destination->id }}">{{ $destination->name }}</option>
                                @endforeach
                            </select>
                            @error('destination')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Rate --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Rate</label>
                            <select id="edit-rate" class="form-select @error('Rate') is-invalid @enderror"
                                name="rate_id" @if (Auth::user()->hasRole('salesman')) disabled="disabled" @endif>
                                <option selected disabled>Select Rate</option>
                                <option value=""></option>
                                @foreach ($rates->sortBy('name') as $rate)
                                    <option value="{{ $rate->id }}">{{ $rate->name }}</option>
                                @endforeach
                            </select>
                            @error('Rate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Salesman --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Salesman</label>
                            <select id="edit-salesman" class="form-select @error('salesman') is-invalid @enderror"
                                name="salesman" @if (Auth::user()->hasRole('salesman')) disabled="disabled" @endif>
                                <option disabled>Select Salesman</option>
                                <option value=""></option>
                                @foreach ($users->sortBy('first_name') as $user)
                                    <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                                @endforeach
                            </select>
                            @error('salesman')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Sales Number --}}
                        <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Sales No.</label>
                            <input type="text"
                                class="form-control form-control-user @error('sales_num') is-invalid @enderror"
                                id="edit-sales_num" placeholder="Sales NO." name="sales_num"
                                value="{{ old('PurchaseCode') }}">
                            @error('sales_num')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Sales Notes --}}
                        <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                            <span></span>Sales Notes</label>
                            <textarea class="form-control form-control-user @error('sales_notes') is-invalid @enderror" id="edit_sales_notes"
                                placeholder="Sales Notes" name="sales_notes" value="{{ old('sales_notes') }}"></textarea>
                            @error('sales_notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Accounting Notes --}}
                        <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                            <span></span>Accounting Notes</label>
                            <textarea class="form-control form-control-user @error('accounting_notes') is-invalid @enderror"
                                id="edit_accounting_notes" placeholder="Accounting Notes" name="accounting_notes"
                                value="{{ old('accounting_notes') }}"></textarea>
                            @error('accounting_notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Driver Instruction --}}
                        <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                            <span style="color:red;">*</span>Driver Instructions</label>
                            <textarea class="form-control form-control-user @error('driver_instructions') is-invalid @enderror"
                                id="edit_driver_instructions" placeholder="Driver Instruction" name="driver_instructions"
                                value="{{ old('driver_instructions') }}"></textarea>
                            @error('driver_instructions')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Completed --}}
                        <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                            Completed</label>
                            <select id="edit_delivered" class="form-select @error('status') is-invalid @enderror"
                                name="delivered">
                                <option>Select Status</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- ship --}}
                        <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                            Don't ship</label>
                            <select id="edit_noship" class="form-select @error('status') is-invalid @enderror"
                                name="noship">
                                <!-- <option selected>Select Shiped</option> -->
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- void --}}
                        <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                            Void</label>
                            <select id="edit_void" class="form-select @error('status') is-invalid @enderror"
                                name="void">
                                <option selected>Select Void</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3 edit-button">Save</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="">Cancel</a>
                    <a data-ide="" id="change-log-button" class="btn btn-primary float-right mr-3 mb-3"
                        href="javascript:void(0)" onclick="changelog({{ $dispatch->id ?? '0' }})">Change Log</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmeditmmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Release Code</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Sorry, this release code has already been used. Do you wish to save this record
                anyway?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" id="confirm_edit_cancel">Cancel</button>
                <button class="btn btn-success" type="button" id="confirm_edit_yes">Save</button>
            </div>
        </div>
    </div>
</div>
<?php
/*<div class="modal fade" id="confirmeditmmodal" role="dialog" aria-labelledby="deleteModalExample" aria-hidden="true" style="border-color: ##007bff">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">Release Code</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        Sorry, this release code has already been used. Do you wish to save this record anyway?
                    </div>
                </div>

                <div class="panel-footer row"><!-- panel-footer -->
                    <div class="col-xs-6">&nbsp;</div>
                    <div class="col-xs-2 text-right">
                        <div class="previous">
                            <button type="button" id= "confirm_edit_yes" class="btn btn-success btn-user float-right mb-3">SAVE</button>
                        </div>
                    </div>
                    <div class="col-xs-2">&nbsp;</div>
                    <div class="col-xs-2 text-right">
                        <div class="next">
                        <button type="button" id= "confirm_edit_cancel" class="btn btn-success btn-user float-right mb-3">CANCEL</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>*/
?>
