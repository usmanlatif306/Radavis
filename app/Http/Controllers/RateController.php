<?php

namespace App\Http\Controllers;

use App\Models\rate;
use App\Models\User;
use App\Exports\RatesExport;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
    //     $this->middleware('permission:user-create', ['only' => ['create','store', 'updateStatus']]);
    //     $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:user-delete', ['only' => ['delete']]);
    // }



    public function index()
    {
        $rates = rate::where('active',1)->get();
        $value = NULL;
        foreach ($rates as $record_num=>$row)
        {
            if ($row->active == TRUE)
            {
                $value .= $row->name . "\n";
            }
        }
        return view('rate.index', ['rates' => $rates, 'value'=>$value]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rate.add');
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
            'name'    => 'required',
            //'active'  =>  'required|numeric|in:0,1',
        ]);


       // $this->db->query("UPDATE rates SET active=0");
       DB::table('rates')
      // ->where('id', $user->id)
       ->update(['active' => 0]);

    $new_rates = array_unique( explode("\n", str_replace("\r", NULL, strtolower($request->name) ) ) );

     

    foreach ($new_rates as $name) {
       // DB::beginTransaction();
        try {
        
            $rate = rate::updateOrCreate(
                
                ['name'    =>  $name],
               ['active'        => 1]

            );




            


            // Commit And Redirected To Listing
            //DB::commit();
           

        } catch (\Throwable $th) {
            // Rollback and return with Error
         //   DB::rollBack();
         //   return redirect()->back()->withInput()->with('error', $th->getMessage());
        }

       // 
    }
    return redirect()->route('rate.index')->with('success','Rate Inserted Successfully.');
    }

    public function updateStatus($rate_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'rate_id'   => $rate_id,
            'active'    => $status
        ], [
            'rate_id'   =>  'required|exists:rates,id',
            'active'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if($validate->fails()){
            return redirect()->route('rate.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            rate::whereId($rate_id)->update(['active' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('rate.index')->with('success','Rate Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function show(rate $rate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function edit(rate $rate)
    {
        return view('rate.edit')->with([
            'rate'  => $rate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rate $rate)
    {
        // Validations
        $request->validate([
            'name'      =>  'required|unique:rates,name,'.$rate->id.',id',
            'active'    =>  'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();
        try {

            //dd($request);
            $rate_updated = rate::whereId($rate->id)->update([
                'name'      => $request->name,
                'active'    => $request->active,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('rate.index')->with('success','Rate Updated Successfully.');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(rate $rate)
    {
        //
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            // Delete User
            rate::whereId($request->rate_id)->delete();

            DB::commit();
            return redirect()->route('rate.index')->with('success', 'Rate Deleted Successfully!.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function export() 
    {
        return Excel::download(new RatesExport, 'Rates.xlsx');
    }
}
