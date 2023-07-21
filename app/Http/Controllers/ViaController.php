<?php

namespace App\Http\Controllers;

use App\Models\Via;
use App\Models\Destination;
use App\Models\rate;
use App\Models\User;
use App\Exports\ViasExport;
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

class ViaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Via::whereNull('equip_type')->update([
            'equip_type' => [],
            'service_area' => [],
        ]);


        if ($request->ajax()) {
            $status = $request->status === 'inactive' ? 0 : 1;
            $data = Via::with('user')->where('active', $status);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user ?  $row->user?->full_name . '<br>(' . $row->user?->email . ')' : '<span class="text-danger">No link</span>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->active == 0) {
                        return '<span class="badge badge-danger">Inactive</span>';
                    } elseif ($row->active == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route("via.edit", ["via" => $row->id]) . '" class="btn btn-primary m-2"><i class="fa fa-pen"></i></a>';
                    $btn .=  '<a class="btn btn-danger m-2" href="#" data-toggle="modal" onclick = "ConfirmDelete(' . $row->id . ')"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['user', 'status', 'action'])
                ->make(true);
        }

        return view('via.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('via.add', [
            'users' => User::select(['id', 'first_name', 'last_name', 'email'])->where('role_id', 4)->get(),
        ]);
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
            'name'    => 'required|max:255|string|unique:vias,name',
            'contact_name'    => 'required|max:255|string',
            'email'    => 'required|max:255|email|unique:vias,email',
            'phone'    => 'required|max:255',
            'user_id'    => 'required|exists:users,id',
            'trucks'    => 'required|integer',
            'equip_type'    => 'required|array',
            'service_area'    => 'required|array',
            'active'  =>  'required|numeric|in:0,1',
        ]);


        DB::beginTransaction();
        try {
            // Store Data
            $vias = Via::create([
                'name'    => $request->name,
                'contact_name'    => $request->contact_name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'active'  => $request->active,
                'user_id'  => $request->user_id,
                'trucks'  => $request->trucks,
                'equip_type'  => $request->equip_type,
                'service_area'  => $request->service_area,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('via.index')->with('success', 'Via Added Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function updateStatus($via_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'via_id'   => $via_id,
            'active'    => $status
        ], [
            'via_id'   =>  'required|exists:vias,id',
            'active'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('via.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            Via::whereId($via_id)->update(['active' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('via.index')->with('success', 'via Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Via  $via
     * @return \Illuminate\Http\Response
     */
    public function show(Via $via)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Via  $via
     * @return \Illuminate\Http\Response
     */
    public function edit(Via $via)
    {
        return view('via.edit')->with([
            'via'  => $via,
            'users' => User::select(['id', 'first_name', 'last_name', 'email'])->where('role_id', 4)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Via  $via
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Via $via)
    {
        // Validations
        $request->validate([
            'name'      =>  'required|unique:vias,name,' . $via->id . ',id',
            'contact_name'    => 'required|max:255|string',
            'email'    => 'required|max:255|email|unique:vias,email,' . $via->id . ',id',
            'phone'    => 'required|max:255',
            'active'    =>  'required|numeric|in:0,1',
            'user_id'    => 'required|exists:users,id',
            'trucks'    => 'required|integer',
            'equip_type'    => 'required|array',
            'service_area'    => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $via_updated = Via::whereId($via->id)->update([
                'name'      => $request->name,
                'contact_name'    => $request->contact_name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'active'    => $request->active,
                'user_id'  => $request->user_id,
                'trucks'  => $request->trucks,
                'equip_type'  => $request->equip_type,
                'service_area'  => $request->service_area,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('via.index')->with('success', 'Via Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Via  $via
     * @return \Illuminate\Http\Response
     */
    public function destroy(Via $via)
    {
        //
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            // Delete User
            Via::whereId($request->via_id)->delete();

            DB::commit();
            return redirect()->route('via.index')->with('success', 'Via Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function export()
    {
        return Excel::download(new ViasExport, 'vias.xlsx');
    }
}
