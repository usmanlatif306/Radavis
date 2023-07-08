<?php

$date_to_display = date('Y-m-d');
if (isset($_GET['date'])) {
    $date = $_GET['date'];

    $date_to_display = date('Y-m-d', strtotime($date));
}

$select_sale_man = null;

if (Auth::user()->hasRole('salesman')) {
    $select_sale_man = Auth::user()->id;
}
?>

<div class="modal fade" id="createModal" role="dialog" aria-labelledby="deleteModalExample" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">Create Dispatch</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="POST" id="disptach-form" action="{{ route('dispatch.store') }}">
                <div class="modal-body">
                    @csrf
                    <div class="form-group row">

                        {{-- Date --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Date</label>
                            <input type="date"
                                class="form-control form-control-user @error('date') is-invalid @enderror"
                                id="date" name="date" value="{{ $date_to_display }}">

                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Commodity --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Commodity</label>
                            <select id="add-commoditie" onchange="UpdateSuppliers()"
                                class="form-control form-control-user @error('commodity') is-invalid @enderror"
                                name="commodity_id">
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
                            <select id="add-supplier" onchange="Updateexits()"
                                class="form-control form-control-user @error('supplier') is-invalid @enderror"
                                name="supplier_id">
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
                            <select id="add-exits"
                                class="form-control form-control-user @error('exit') is-invalid @enderror"
                                name="exit_id">
                                <option selected="selected" disabled="disabled">Select Exits</option>
                            </select>

                            @error('exit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Release Code --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Release Code</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">-1</span>
                                </div>
                                <input type="text"
                                    class="form-control form-control-user @error('PurchaseCode') is-invalid @enderror"
                                    id="release_code_new" name="release_code" aria-describedby="basic-addon1"
                                    value="{{ old('PurchaseCode') }}">
                            </div>
                            @error('PurchaseCode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Via --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Via</label>
                            <select class="form-control form-control-user @error('via') is-invalid @enderror"
                                name="via_id">
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
                            <select class="form-control form-control-user @error('destination') is-invalid @enderror"
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
                            <select class="form-control form-control-user @error('Rate') is-invalid @enderror"
                                name="rate_id">
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
                            <select class="form-control form-control-user @error('salesman') is-invalid @enderror"
                                name="salesman">
                                <option selected disabled>Select Salesman</option>
                                <option value=""></option>
                                @foreach ($users->sortBy('first_name') as $user)
                                    <option value="{{ $user->id }}" <?php if ($select_sale_man != '') {
                                        if ($user->id == Auth::user()->id) {
                                            echo 'selected';
                                        }
                                    } ?>>{{ $user->first_name }}
                                    </option>
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
                            <textarea class="form-control form-control-user @error('sales_notes') is-invalid @enderror" id="sales_notes"
                                name="sales_notes" value="{{ old('sales_notes') }}"></textarea>
                            @error('sales_notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Accounting Notes --}}
                        <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                            <span></span>Accounting Notes</label>
                            <textarea class="form-control form-control-user @error('accounting_notes') is-invalid @enderror"
                                id="accounting_notes" name="accounting_notes" value="{{ old('accounting_notes') }}"></textarea>
                            @error('accounting_notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Driver Instruction --}}
                        <div class="col-sm-12 mb-6 mt-6 mb-sm-0">
                            <span style="color:red;">*</span>Driver Instructions</label>
                            <textarea class="form-control form-control-user @error('driver_instructions') is-invalid @enderror"
                                id="driver_instructions" name="driver_instructions" value="{{ old('driver_instructions') }}"></textarea>
                            @error('driver_instructions')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>X Records</label>
                            <input type="number" value="1" name="x_no_records" class="form-control form-control-user">


                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="add-disptach"
                        class="btn btn-success btn-user float-right mb-3">Save</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="confirnewmmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <button class="btn btn-secondary" type="button" id="confirm_new_cancel">Cancel</button>
                <button class="btn btn-success" type="button" id="confirm_new_yes">Save</button>
            </div>
        </div>
    </div>
</div>

<?php

/*<div class="modal fade" id="confirnewmmodal" role="dialog" aria-labelledby="deleteModalExample" aria-hidden="true" style="border-color: ##007bff">
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
                            <button type="button" id= "confirm_new_yes" class="btn btn-success btn-user float-right mb-3">SAVE</button>
                        </div>
                    </div>
                    <div class="col-xs-2">&nbsp;</div>
                    <div class="col-xs-2 text-right">
                        <div class="next">
                        <button type="button" id= "confirm_new_cancel" class="btn btn-success btn-user float-right mb-3">CANCEL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>*/
?>
