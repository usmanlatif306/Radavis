<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Exits;
use App\Models\rate;
use App\Models\User;
use App\Exports\SuppliersExport;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name_added', function ($row) {
                    return '<a style="color:#212529" href = "' . route("supplier.exitindex", ["supplier" => $row->id]) . '"><span>' . $row->name . '</span></a>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->active == 0) {
                        return '<span class="badge badge-danger">Inactive</span>';
                    } elseif ($row->active == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route("supplier.edit", ["supplier" => $row->id]) . '" class="btn  btn-sm btn-primary m-2"><i class="fa fa-pen"></i></a>';
                    $btn .=  '<a class="btn btn-sm btn-danger m-2" href="#" data-toggle="modal" onclick = "ConfirmDelete(' . $row->id . ')"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['name_added', 'status', 'action'])
                ->make(true);
        }
        return view('supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'active'  =>  'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();
        try {

            //dd($request);
            // Store Data
            $supplier = Supplier::create([
                'name'    => $request->name,
                'active'  => $request->active,
            ]);


            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('supplier.index')->with('success', 'Suppliers Inserted Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function updateStatus($supplier_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'supplier_id'   => $supplier_id,
            'active'    => $status
        ], [
            'supplier_id'   =>  'required|exists:suppliers,id',
            'active'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('supplier.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            Supplier::whereId($supplier_id)->update(['active' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('supplier.index')->with('success', 'Supplier Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit')->with([
            'supplier'  => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        // Validations
        $request->validate([
            'name'      =>  'required|unique:suppliers,name,' . $supplier->id . ',id',
            'active'    =>  'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();
        try {

            //dd($request);
            $supplier_updated = Supplier::whereId($supplier->id)->update([
                'name'      => $request->name,
                'active'    => $request->active,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('supplier.index')->with('success', 'Supplier Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }

    public function delete(Request $request)
    {
        //dd($request);
        DB::beginTransaction();
        try {
            // Delete User
            Supplier::whereId($request->supplier_id)->delete();
            //$exits =  Supplier::getexitofsupplier($request->supplier_id)->delete();

            DB::commit();
            return redirect()->route('supplier.index')->with('success', 'Supplier Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function exitindex(Supplier $supplier)
    {
        DB::beginTransaction();
        try {
            // Get Supplier for this commodity
            $exitall = Exits::all();
            $supplier = Supplier::whereId($supplier->id)->first();
            $id_supp = $supplier->id;
            $exits =  Supplier::getexitofsupplier($id_supp);

            DB::commit();
            return view('supplier.exitindex', ['supplier' => $supplier, 'exits' => $exits, 'exitall' => $exitall]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function exitstore(Request $request)
    {
        // Validation
        $validate = Validator::make([
            'supplier_id'   => $request->supplier_id,
            'exit_id' => $request->exit_id
        ], [
            'exit_id'   =>  'required|exists:exits,id',
            'supplier_id'    =>  'required|exists:suplliers,id',
        ]);
        DB::beginTransaction();
        try {

            $insert = DB::table('exit_to_supplier')->insert(['supplier_id' => $request->supplier_id, 'exit_id' => $request->exit_id]);
            // Get Supplier for this commodity
            $exitall = Exits::all();
            $supplier = Supplier::whereId($request->supplier_id)->first();
            $id_supp = $supplier->id;
            $exits =  Supplier::getexitofsupplier($id_supp);

            DB::commit();
            return redirect()->route('supplier.exitindex', ['supplier' => $supplier, 'exits' => $exits, 'exitall' => $exitall])->with('success', 'Exit Inserted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function suppexitdestroy(Supplier $supplier, Request $request)
    {
        DB::beginTransaction();
        try {
            DB::table('exit_to_supplier')->where(['exit_id'   => $request->exit_id, 'supplier_id' => $supplier->id])->delete();

            $exitall = Exits::all();
            $supplier = Supplier::whereId($supplier->id)->first();
            $id_supp = $supplier->id;
            $exits =  Supplier::getexitofsupplier($id_supp);
            DB::commit();
            return redirect()->route('supplier.exitindex', ['supplier' => $supplier, 'exits' => $exits, 'exitall' => $exitall])->with('success', 'Supplier Deleted Successfully from Commodity!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new SuppliersExport, 'Suppliers.xlsx');
    }
}
