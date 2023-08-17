<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationTierRequest;
use App\Models\LocationTier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class LocationTierController extends Controller
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
            $data = LocationTier::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('price', function ($row) {
                    return '$' . $row->price;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 0) {
                        return '<span class="badge badge-danger">Inactive</span>';
                    } elseif ($row->status == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route("tiers.edit", ["tier" => $row->id]) . '" class="btn btn-sm btn-primary m-2"><i class="fa fa-pen"></i></a>';
                    $btn .= '<a class="btn btn-sm btn-danger m-2" href="#" data-toggle="modal" onclick = "ConfirmDelete(' . $row->id . ')"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('location_tiers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('location_tiers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationTierRequest $request)
    {
        LocationTier::create($request->validated());

        return to_route('tiers.index')->with('success', 'New Location Tier Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LocationTier  $tier
     * @return \Illuminate\Http\Response
     */
    public function show(LocationTier $tier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LocationTier  $tier
     * @return \Illuminate\Http\Response
     */
    public function edit(LocationTier $tier)
    {
        return view('location_tiers.edit', compact('tier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LocationTier  $tier
     * @return \Illuminate\Http\Response
     */
    public function update(LocationTierRequest $request, LocationTier $tier)
    {
        $tier->update($request->validated());

        return to_route('tiers.index')->with('success', 'Location Tier Edited Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $tier = LocationTier::find($request->tier_id);
            $tier->delete();

            DB::commit();
            return to_route('tiers.index')->with('success', 'Location Tier Deleted Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
