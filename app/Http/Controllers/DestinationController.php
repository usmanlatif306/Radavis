<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\rate;
use App\Models\User;
use App\Exports\DestinationsExport;
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


class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data = Destination::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function($row){
                        if($row->active == 0){
                            return '<span class="badge badge-danger">Inactive</span>';
                        }elseif ($row->active == 1){
                            return '<span class="badge badge-success">Active</span>';
                        }
                    }) 
                    ->addColumn('action', function($row){
                        $btn = '<a href="'.route("destination.edit", ["destination" => $row->id]).'" class="btn btn-primary m-2"><i class="fa fa-pen"></i></a>';
                        $btn .= '<a class="btn btn-danger m-2" href="#" data-toggle="modal" onclick = "ConfirmDelete('.$row->id.')"><i class="fas fa-trash"></i></a>';     
                        return $btn;
                    })  
                    ->rawColumns(['status','action'])
                    ->make(true);
        }
        
        return view('destination.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('destination.add');
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
            // Store Data
            $destination = Destination::create([
                'name'    => $request->name,
                'active'        => $request->active,
            ]);


            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('destination.index')->with('success','Destination Added Successfully.');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }


    public function updateStatus($destination_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'destination_id'   => $destination_id,
            'active'    => $status
        ], [
            'destination_id'   =>  'required|exists:destinations,id',
            'active'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if($validate->fails()){
            return redirect()->route('destination.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            Destination::whereId($destination_id)->update(['active' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('destination.index')->with('success','Destination Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function show(Destination $destination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function edit(Destination $destination)
    {
        return view('destination.edit')->with([
            'destination'  => $destination
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Destination $destination)
    {
        // Validations
        $request->validate([
            'name'      =>  'required|unique:destinations,name,'.$destination->id.',id',
            'active'    =>  'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();
        try {

            //dd($request);
            $destination_updated = Destination::whereId($destination->id)->update([
                'name'      => $request->name,
                'active'    => $request->active,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('destination.index')->with('success','Destination Updated Successfully.');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destination $destination)
    {
        //
    }


    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            // Delete User
            Destination::whereId($request->destination_id)->delete();

            DB::commit();
            return redirect()->route('destination.index')->with('success', 'Destination Deleted Successfully!.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function export() 
    {
        return Excel::download(new DestinationsExport, 'Destinations.xlsx');
    }
}
