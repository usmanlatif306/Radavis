<?php

namespace App\Http\Controllers;

use App\Models\Exits;
use App\Models\rate;
use App\Models\User;
use App\Exports\ExitsExport;
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

class ExitsController extends Controller
{
    private function cleanNote($string)
    {
        $string = str_replace('<span style="color:red">', '', $string);
        $string = str_replace('</span>', '', $string);
        $string = str_replace('<span style="color:red; font-weight: 900;">', '', $string);
        $string = str_replace('<span style="color:#ff0000">', '', $string);
        $string = str_replace('<span style="color: red; font-weight: bold;">', '', $string);
        $string = str_replace('<span style="color:red; font-weight: bold;">', '', $string);
        $string = str_replace('<span style="font-size: 18px;color: red;">', '', $string);
        $string = str_replace('<span style="font-weight:bold;font-size:18px;color:red;">', '', $string);
        $string = str_replace('<span style="color: red; font-size: 18px;"><strong>', '', $string);
        $string = str_replace('<strong>', '', $string);
        $string = str_replace('</strong>', '', $string);
        $string = str_replace('<span style="color: red;">', '', $string);
        $string = str_replace('<span style="color:#ff0000;font-weight: bold;">', '', $string);
        $string = str_replace('<span style="color:red; font-weight:bold;">', '', $string);
        $string = str_replace('<span style="color:red"><strong>', '', $string);
        $string = str_replace('<span style="font-weight:bold">', '', $string);
        $string = str_replace('<span style="color: red; font-weight: bold; font-size: 18px;">', '', $string);
        $string = str_replace('<span style="color: red; font-size:16px;font-weight: 900;">', '', $string);
        $string = str_replace('<span style="font-weight:bold; color: red;">', '', $string);

        return $string;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $exits = Exits::whereNull('address')->get();
        foreach ($exits as $exit) {
            $new = explode('<br />', $exit->name);
            $exit->update([
                'name' => $new[0],
                'address' => isset($new[1]) ? $new[1] : null,
                'note' => (isset($new[2]) ? $this->cleanNote($new[2]) : null) . (isset($new[3]) ? ' ' . $this->cleanNote($new[3]) : '') . (isset($new[4]) ? ' ' . $this->cleanNote($new[4]) : ''),
            ]);
        }

        if ($request->ajax()) {
            $data = Exits::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->active == 0) {
                        return '<span class="badge badge-danger">Inactive</span>';
                    } elseif ($row->active == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route("exit.edit", ["exit" => $row->id]) . '" class="btn btn-primary btn-sm m-2"><i class="fa fa-pen"></i></a>';
                    $btn .=  '<a class="btn btn-sm btn-danger m-2" href="#" data-toggle="modal" onclick = "ConfirmDelete(' . $row->id . ')"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('exit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('exit.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'name'       => 'required|string|max:255',
            'address'    => 'required|string|max:255',
            'note'       => 'nullable|string|max:255',
            'active'     =>  'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();
        try {

            //dd($request);
            // Store Data
            $exit = Exits::create([
                'name'    => $request->name,
                'address' => $request->address,
                'note'    => $request->note,
                'active'  => $request->active,
            ]);


            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('exit.index')->with('success', 'Exits Inserted Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }


    public function updateStatus($exit_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'exit_id'   => $exit_id,
            'active'    => $status
        ], [
            'exit_id'   =>  'required|exists:exits,id',
            'active'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('exit.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            Exits::whereId($exit_id)->update(['active' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('exit.index')->with('success', 'Exit Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exits  $exits
     * @return \Illuminate\Http\Response
     */
    public function show(Exits $exits)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exits  $exits
     * @return \Illuminate\Http\Response
     */
    public function edit(Exits $exit)
    {

        return view('exit.edit')->with([
            'exit'  => $exit
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exits  $exits
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exits $exit)
    {
        // Validations
        $request->validate([
            'name'      =>  'required|unique:exits,name,' . $exit->id . ',id',
            'address'   => 'required|string|max:255',
            'note'      => 'nullable|string|max:255',
            'active'    =>  'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();
        try {

            //dd($request);
            $exits_updated = Exits::whereId($exit->id)->update([
                'name'      => $request->name,
                'address'   => $request->address,
                'note'      => $request->note,
                'active'    => $request->active,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('exit.index')->with('success', 'Exits Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exits  $exits
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exits $exits)
    {
        //
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            // Delete User
            Exits::whereId($request->exit_id)->delete();

            DB::commit();
            return redirect()->route('exit.index')->with('success', 'Exit Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new ExitsExport, 'Exits.xlsx');
    }
}
