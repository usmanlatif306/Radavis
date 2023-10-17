<div class="modal fade" id="bulkeditModal" role="dialog" aria-labelledby="deleteModalExample" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">Bulk Edit Dispatch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('dispatch.bulkedit') }}" class="bulk-edit-form">
                <input type="hidden" name="ids_to_edit" value="" id="ids_to_edit">
                <div class="modal-body">
                    @csrf
                    <div class="form-group row">

                        {{-- Date --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Date</label>
                            <input type="date"
                                class="form-control form-control-user @error('date') is-invalid @enderror"
                                placeholder="Select Date" name="date" value="">

                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Commodity --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Commodity</label>
                            <select onchange="BulkUpdateSuppliers()"
                                class="form-select @error('commodity') is-invalid @enderror" name="commodity_id"
                                id="bulk-commoditie">
                                <option selected disabled>Select Commodity</option>
                                @foreach ($commodities->sortBy('name') as $commoditie)
                                    <option style="color:{{ $commoditie->color }}" value="{{ $commoditie->id }}">
                                        {!! $commoditie->name !!}</option>
                                @endforeach
                            </select>

                            @error('commodity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Supplier --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Supplier</label>
                            <select id="bulk-supplier" onchange="BulkUpdateexits()"
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
                                id="purchasecode" name="purchase_code" value="{{ old('PurchaseCode') }}">

                            @error('PurchaseCode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        {{-- Exits --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Exits</label>
                            <select class="form-select @error('exit') is-invalid @enderror" name="exit_id"
                                id="bulk-exits" @if (Auth::user()->hasRole('salesman')) disabled="disabled" @endif>
                                <option selected="selected" disabled="disabled">Select Exits</option>
                            </select>

                            @error('exit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        {{-- Via --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Via</label>
                            <select id="bulk-via" class="form-select @error('via') is-invalid @enderror" name="via_id"
                                @if (Auth::user()->hasRole('salesman')) disabled="disabled" @endif>
                                <option selected disabled>Select Via</option>
                                @foreach ($vias->sortBy('name') as $via)
                                    <option value="{{ $via->id }}">{!! $via->name !!}</option>
                                @endforeach
                            </select>
                            @error('via')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Destination --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Destination</label>
                            <select id="bulk-destination" class="form-select @error('destination') is-invalid @enderror"
                                name="destination_id">
                                <option selected disabled>Select Destination</option>
                                @foreach ($destinations->sortBy('name') as $destination)
                                    <option value="{{ $destination->id }}">{!! $destination->name !!}</option>
                                @endforeach
                            </select>
                            @error('destination')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Rate --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Rate</label>
                            <select class="form-select @error('Rate') is-invalid @enderror" name="rate_id"
                                @if (Auth::user()->hasRole('salesman')) disabled="disabled" @endif>
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
                            <select id="bulk-salesman" class="form-select @error('salesman') is-invalid @enderror"
                                name="salesman" @if (Auth::user()->hasRole('salesman')) disabled="disabled" @endif>
                                <option selected disabled>Select Salesman</option>
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
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Sales No.</label>
                            <input type="text"
                                class="form-control form-control-user @error('sales_num') is-invalid @enderror"
                                id="sales_num" name="sales_num" value="{{ old('PurchaseCode') }}">
                            @error('sales_num')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Sales Notes --}}
                        <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                            <span></span>Sales Notes</label>
                            <textarea class="form-control form-control-user @error('sales_notes') is-invalid @enderror" placeholder="Sales Notes"
                                name="sales_notes" value="{{ old('sales_notes') }}"></textarea>
                            @error('sales_notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Accounting Notes --}}
                        <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                            <span></span>Accounting Notes</label>
                            <textarea class="form-control form-control-user @error('accounting_notes') is-invalid @enderror"
                                placeholder="Accounting Notes" name="accounting_notes" value="{{ old('accounting_notes') }}"></textarea>
                            @error('accounting_notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Driver Instruction --}}
                        <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                            <span style="color:red;">*</span>Driver Instructions</label>
                            <textarea class="form-control form-control-user @error('driver_instructions') is-invalid @enderror"
                                placeholder="Driver Instruction" name="driver_instructions" value="{{ old('driver_instructions') }}"></textarea>
                            @error('driver_instructions')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- Completed --}}
                        <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                            Completed</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="delivered">
                                <option disabled selected>Select Status</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- ship --}}
                        <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                            Stop Shipment</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="noship">
                                <option disabled selected>Select Shipped</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- void --}}
                        <div class="col-sm-4 mb-2 mt-2 mb-sm-0">
                            Void Shipment</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="void">
                                <option disabled selected>Select Void</option>
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
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
