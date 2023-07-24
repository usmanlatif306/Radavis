<?php

namespace App\Http\Controllers;

use App\Models\Commoditie;
use App\Models\Supplier;
use App\Models\Exits;
use App\Models\rate;
use App\Models\User;
use App\Exports\CommoditiesExport;
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



class CommoditieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Commoditie::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name_added', function ($row) {
                    return '<a href = "' . route("commoditie.supplierindex", ["commoditie" => $row->id]) . '"><span style="color:' . $row->color . '">' . $row->name . '</span></a>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->active == 0) {
                        return '<span class="badge badge-danger">Inactive</span>';
                    } elseif ($row->active == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route("commoditie.edit", ["commoditie" => $row->id]) . '" class="btn btn-sm btn-primary m-2"><i class="fa fa-pen"></i></a>';
                    $btn .= '<a class="btn btn-sm btn-danger m-2" href="#" data-toggle="modal" onclick = "ConfirmDelete(' . $row->id . ')"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['name_added', 'status', 'action'])
                ->make(true);
        }
        return view('commoditie.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('commoditie.add');
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
            'color'   => 'required',
            'active'  => 'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();
        try {
            // Store Data
            $commoditie = Commoditie::create([
                'name'    => $request->name,
                'color'    => $request->color,
                'active'  => $request->active,
            ]);


            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('commoditie.index')->with('success', 'Commoditie Inserted Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }


    public function updateStatus($commoditie_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'commoditie_id'   => $commoditie_id,
            'active'    => $status
        ], [
            'commoditie_id'   =>  'required|exists:commodities,id',
            'active'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('commoditie.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            Commoditie::whereId($commoditie_id)->update(['active' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('commoditie.index')->with('success', 'commoditie Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commoditie  $commoditie
     * @return \Illuminate\Http\Response
     */
    public function show(Commoditie $commoditie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commoditie  $commoditie
     * @return \Illuminate\Http\Response
     */
    public function edit(Commoditie $commoditie)
    {
        return view('commoditie.edit')->with([
            'commoditie'  => $commoditie
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commoditie  $commoditie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commoditie $commoditie)
    {
        // Validations
        $request->validate([
            'name'      =>  'required|unique:commodities,name,' . $commoditie->id . ',id',
            'color'     =>  'required',
            'active'    =>  'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();
        try {

            //dd($request);
            $commoditie_updated = Commoditie::whereId($commoditie->id)->update([
                'name'      => $request->name,
                'color'     => $request->color,
                'active'    => $request->active,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('commoditie.index')->with('success', 'Commoditie Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commoditie  $commoditie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commoditie $commoditie)
    {
        //
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            // Delete User
            Commoditie::whereId($request->commiditie_id)->delete();

            DB::commit();
            return redirect()->route('commoditie.index')->with('success', 'Commoditie Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function supplierindex(Commoditie $commoditie)
    {
        DB::beginTransaction();
        try {
            // Get Supplier for this commodity
            $suppliersall = Supplier::all();
            $commoditie = Commoditie::whereId($commoditie->id)->first();
            $id_comm = $commoditie->id;
            $suppliers =  Commoditie::getsupplierofcommodity($id_comm);

            DB::commit();
            return view('commoditie.supplierindex', ['commoditie' => $commoditie, 'suppliers' => $suppliers, 'comsuppliers' => $suppliersall]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function supplierstore(Request $request)
    {
        // Validation
        $validate = Validator::make([
            'supplier_id'   => $request->supplier_id,
            'commoditie_id' => $request->commoditie_id
        ], [
            'commoditie_id'   =>  'required|exists:commodities,id',
            'supplier_id'    =>  'required|exists:suplliers,id',
        ]);
        DB::beginTransaction();
        try {

            $insert = DB::table('supplier_to_commodity')->insert(['supplier_id'   => $request->supplier_id, 'commodity_id' => $request->commoditie_id]);
            // Get Supplier for this commodity
            $suppliersall = Supplier::all();
            $commoditie = Commoditie::whereId($request->commoditie_id)->first();
            $suppliers =  Commoditie::getsupplierofcommodity($request->commoditie_id);

            DB::commit();
            return redirect()->route('commoditie.supplierindex', ['commoditie' => $commoditie, 'suppliers' => $suppliers, 'comsuppliers' => $suppliersall])->with('success', 'Commoditie Supplier Inserted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function commsuppdestroy(Commoditie $commoditie, Request $request)
    {
        DB::beginTransaction();
        try {
            // Delete supplier from commodity
            DB::table('supplier_to_commodity')->where(['supplier_id'   => $request->supplier_id, 'commodity_id' => $commoditie->id])->delete();

            $suppliersall = Supplier::all();
            $commoditie = Commoditie::whereId($commoditie->id)->first();
            $id_comm = $commoditie->id;
            $suppliers =  Commoditie::getsupplierofcommodity($id_comm);

            DB::commit();
            return redirect()->route('commoditie.supplierindex', ['commoditie' => $commoditie, 'suppliers' => $suppliers, 'comsuppliers' => $suppliersall])->with('success', 'Supplier Deleted Successfully from Commodity!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new CommoditiesExport, 'Commodities.xlsx');
    }
}
