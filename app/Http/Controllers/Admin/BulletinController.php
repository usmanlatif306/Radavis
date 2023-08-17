<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulletinRequest;
use App\Models\Bulletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DataTables;

class BulletinController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Bulletin::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status == 0) {
                        return '<span class="badge badge-danger">Inactive</span>';
                    } elseif ($row->status == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route("bulletins.edit", ["bulletin" => $row->id]) . '" class="btn btn-sm btn-primary m-2"><i class="fa fa-pen"></i></a>';
                    $btn .= '<a class="btn btn-sm btn-danger m-2" href="#" data-toggle="modal" onclick = "ConfirmDelete(' . $row->id . ')"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('bulletins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bulletins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BulletinRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BulletinRequest $request)
    {
        Bulletin::create($request->validated());

        return to_route('bulletins.index')->with('success', 'New Bulletin Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bulletin  $bulletin
     * @return \Illuminate\Http\Response
     */
    public function show(Bulletin $bulletin)
    {
        return view('bulletins.show', compact('bulletin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bulletin  $bulletin
     * @return \Illuminate\Http\Response
     */
    public function edit(Bulletin $bulletin)
    {
        return view('bulletins.edit', compact('bulletin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BulletinRequest  $request
     * @param  \App\Models\Bulletin  $bulletin
     * @return \Illuminate\Http\Response
     */
    public function update(BulletinRequest $request, Bulletin $bulletin)
    {
        $bulletin->update($request->validated());
        $bulletin->reads()->delete();

        return to_route('bulletins.index')->with('success', 'Bulletin Edited Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bulletin  $bulletin
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Bulletin $bulletin)
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $bulletin = Bulletin::find($request->bulletin_id);
            $bulletin->reads()->delete();
            $bulletin->delete();

            DB::commit();
            return to_route('bulletins.index')->with('success', 'Bulletin Deleted Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update Status Of User
     * @param Integer $status
     * @return List Page With Success
     * @author Shani Singh
     */
    public function updateStatus($bulletin, $status)
    {
        // Validation
        $validate = Validator::make([
            'bulletin'   => $bulletin,
            'status'    => $status
        ], [
            'bulletin'   =>  'required|exists:bulletins,id',
            'status'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('bulletins.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            Bulletin::whereId($bulletin)->update(['status' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('bulletins.index')->with('success', 'Bulletin Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
