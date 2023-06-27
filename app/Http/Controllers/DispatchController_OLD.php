<?php

namespace App\Http\Controllers;

use App\Models\dispatch;
use App\Models\Commoditie;
use App\Models\Supplier;
use App\Models\Exits;
use App\Models\rate;
use App\Models\Via;
use App\Models\Destination;
use App\Models\User;
use App\Models\DispatchLog;
use App\Exports\DispatchesExport;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Auth;
use App\Models\Config;

class DispatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function GetDisplayVariables(){

           $display = session('changedisplay');
          if($display == ''){
                //$display = 'all';
                session(['changedisplay' => 'all']);
          }
          $display = session('changedisplay');
        switch ($display)
			{
				case 'all':
				default:
					$void = 0;
					$delivered = FALSE;
					$noship = FALSE;
					break;

				case 'completed':
					$void = FALSE;
					$delivered = 1;
					$noship = FALSE;
					break;

				case 'open':
					$void = 0;
					$delivered = 0;
					$noship = FALSE;
					break;

				case 'noship':
					$void = 0;
					$delivered = FALSE;
					$noship = 1;
					break;

				case 'ship':
					$void = 0;
					$delivered = 0;
					$noship = 0;
					break;

				case 'void':
					$void = 1;
					$delivered = FALSE;
					$noship = FALSE;
					break;
			}

        return array($void,$delivered,$noship);




    }

    public function index(Request $request)
    {
        date_default_timezone_set("America/Los_Angeles");
        $date = $request->date;
        if($date == ''){
            $date_timestamp =  strtotime(date("m/d/Y"));
        }
        else {
            $date_timestamp =  strtotime($date);
        }


        $changedisplay =  $this->GetDisplayVariables();

                    $void      = $changedisplay[0];
					$delivered = $changedisplay[1];
					$noship    = $changedisplay[2];


        $query = dispatch::query();

        if(Auth::user()->hasRole('salesman')){

        //    dd($changedisplay);
        // if($dispatches)
            $query =   $query->where('date',$date_timestamp)->where('salesman', Auth::user()->id);
        }
        else {
            $query = $query->where('date',$date_timestamp);
        }

        if ($delivered !== FALSE) {
			$query =   $query->where('delivered', $delivered);
		}
		if ($noship !== FALSE) {
			$query =   $query->where('noship', $noship);
		}
		if ($void !== FALSE) {
			$query =   $query->where('void', $void);
		}


        $dispatches = $query->get();
        //dd()

        $config = Config::get();
        $commodities = Commoditie::where('active', 1)->get();
        $suppliers = Supplier::where('active', 1)->get();
        $exits = Exits::where('active', 1)->get();
        $rates = rate::where('active', 1)->get();
        $vias = Via::where('active', 1)->get();
        $destinations = Destination::where('active', 1)->get();
        $users = User::where('status', 1)->get();

        return view('dispatch.index', ['dispatches' => $dispatches, 'commodities' => $commodities, 'suppliers' => $suppliers, 'exits' => $exits, 'rates' => $rates, 'vias' => $vias, 'destinations' => $destinations, 'users' => $users,'config'=>$config]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set("America/Los_Angeles");
        $date1 = $request->date;


        $originalDate =$request->date;
        $date1 = date("m/d/Y", strtotime($originalDate));

        $timestamp1 = strtotime($date1);


        // $request->validate([
        //     "date"                  =>  'required',
        //     "commodity_id"          =>  'required',
        //     "supplier_id"           =>  'required',
        //     "purchase_code"         =>  'required',
        //     "exit_id"               =>  'required',
        //     "release_code"          =>  'required',
        //     "via_id"                =>  'required',
        //     "destination_id"        =>  'required',
        //     "rate_id"               =>  'required',
        //     "salesman"              =>  'required',
        //     "sales_num"             =>  'required',
        //     "sales_notes"           =>  'required',
        //     "accounting_notes"      =>  'required',
        //     "driver_instructions"   =>  'required',
        // ]);

        DB::beginTransaction();
        try {

            // Store Data
            for($i = 0; $i < $request->x_no_records ; $i++ ){

            $user = dispatch::create([
                "date"                  =>  $timestamp1,
                "commodity_id"          => $request->commodity_id,
                "supplier_id"           => $request->supplier_id,
                "purchase_code"         => $request->purchase_code,
                "exit_id"               => $request->exit_id,
                "release_code"          => $request->release_code,
                "via_id"                => $request->via_id,
                "destination_id"        => $request->destination_id,
                "rate_id"               => $request->rate_id,
                "salesman"              => $request->salesman,
                "sales_num"             => $request->sales_num,
                "sales_notes"           => $request->sales_notes,
                "accounting_notes"      => $request->accounting_notes,
                "driver_instructions"   => $request->driver_instructions,

            ]);

        }

            // Commit And Redirected To Listing
            DB::commit();
            return  redirect()->back()->with('success', 'Dispatch Created Successfully.');

        } catch (\Throwable $th) {
            DB::rollBack();
           // return redirect()->back()->withInput()->with('error', $th->getMessage());
           return  redirect()->back()->with('error', 'Please select all required fields before adding dispatch');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\dispatch  $dispatch
     * @return \Illuminate\Http\Response
     */
    public function show(dispatch $dispatch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dispatch  $dispatch
     * @return \Illuminate\Http\Response
     */
    public function edit(dispatch $dispatch)
    {
        $dispatches = dispatch::whereId($dispatch->id)->get();
        return $dispatches;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\dispatch  $dispatch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dispatch $dispatch)
    {
        date_default_timezone_set("America/Los_Angeles");

        $dispatch = dispatch::find($request->dispatch_id);
        // Validations
        // foreach ($request->input() as $key => $value) {
        //     if (empty($value)) {
        //         $request->request->set($key, " ");
        //     }
        // }

        // $request->validate([
        //     "date"                  =>  'required',
        //     "commodity_id"          =>  'required',
        //     "supplier_id"           =>  'required',
        //     "purchase_code"         =>  'required',
        //     "exit_id"               =>  'required',
        //     "release_code"          =>  'required',
        //     "via_id"                =>  'required',
        //     "destination_id"        =>  'required',
        //     "rate_id"               =>  'required',
        //     "salesman"              =>  'required',
        //     "sales_num"             =>  'required',
        //     "accounting_notes"      =>  'required',
        //     "driver_instructions"   =>  'required',
        // ]);

        DB::beginTransaction();
        try {
            $date  = strtotime($request->date);
            //dd($request);
            $commoditie_updated = dispatch::whereId($request->dispatch_id)->update([
                "date"                  => $date,
                "commodity_id"          => $request->commodity_id,
                "supplier_id"           => $request->supplier_id,
                "purchase_code"         => $request->purchase_code,
                "exit_id"               => $request->exit_id,
                "release_code"          => $request->release_code,
                "via_id"                => $request->via_id,
                "destination_id"        => $request->destination_id,
                "rate_id"               => $request->rate_id,
                "salesman"              => $request->salesman,
                "sales_num"             => $request->sales_num,
                "sales_notes"           => $request->sales_notes,
                "accounting_notes"      => $request->accounting_notes,
                "driver_instructions"   => $request->driver_instructions,
                "noship"                => $request->noship,
                "delivered"             => $request->delivered,
                "void"                  => $request->void,
            ]);

            // Commit And Redirected To Listing
            $this->UpdateLogs($request,$dispatch);
            //dd();
            DB::commit();







            return  redirect()->back()->with('success', 'Dispatch Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return  redirect()->back()->with('error', 'Please select all required fields before update dispatch');
        }
    }

    public function bulkedit(Request $request, dispatch $dispatch)
    {
        // Validations
        //dd($request->ids_to_edit);

        $log_txt = NULL;

        DB::beginTransaction();

        $request->ids_to_edit = explode(',',$request->ids_to_edit);
       // dd($request->ids_to_edit);
        try {

        //       foreach($request->ids_to_edit as $id){
        //         $dispatch = dispatch::find($id);
        //     $this->UpdateLogs($request,  $dispatch);

        // }


            // if($request->commodity_id != ''){
            //     foreach($request->ids_to_edit as $id){

            //         $dispatch = dispatch::find($id);

            //         $change = dispatch::whereId($id)->update([
            //             "commodity_id" => $request->commodity_id
            //         ]);

            //         $log_txt .= "Changed commodity to {COMMODITY: ".$dispatch->commodity->name ."}";


            //         $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
            //     }
            // }
            if(isset($request->date)){
                date_default_timezone_set("America/Los_Angeles");
                $date  = strtotime($request->date);
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "date" => $date
                    ]);

                    $log_txt = "Changed date to ".$date;

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->commodity_id != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "commodity_id" => $request->commodity_id
                    ]);

                    $log_txt = "Changed commodity to {COMMODITY:".$dispatch->commodity->name."}";

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->supplier_id != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "supplier_id" => $request->supplier_id
                    ]);

                    $log_txt = "Changed supplier to {SUPPLIER:".$dispatch->supplier->name."}";


                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->purchase_code != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "purchase_code" => $request->purchase_code
                    ]);
                    $log_txt = "Changed purchase code to ".$dispatch->purchase_code;

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->exit_id != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "exit_id" => $request->exit_id
                    ]);

                    $log_txt = "Changed exit to {EXIT:".$dispatch->exit->name."}";

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->release_code != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "release_code"          => $request->release_code
                    ]);

                    $log_txt = "Changed release code to ".$dispatch->release_code;

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->via_id != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "via_id"          => $request->via_id
                    ]);
                    $log_txt = "Changed via to {VIA:".$dispatch->via->name."}";

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->destination_id != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "destination_id"          => $request->destination_id
                    ]);
                    $log_txt = "Changed destination to {DESTINATION:".$dispatch->destination->name."}";

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->rate_id != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "rate_id"          => $request->rate_id
                    ]);

                    $log_txt = "Changed rate to {RATE:".$dispatch->rate->name."}";

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->salesman != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "salesman"          => $request->salesman
                    ]);

                    $log_txt = "Changed salesman to {SALESMAN:".$dispatch->salesman1->first_name."}";

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->sales_num != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "sales_num"          => $request->sales_num
                    ]);

                    $log_txt = "Changed sales number to ".$dispatch->sales_num." .";

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->sales_notes != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "sales_notes"          => $request->sales_notes
                    ]);

                    $log_txt = "Changed sales notes";

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->accounting_notes != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "accounting_notes"          => $request->accounting_notes
                    ]);

                    $log_txt = "Changed accounting notes";

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->driver_instructions != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "driver_instructions"          => $request->driver_instructions
                    ]);

                    $log_txt = "Changed driver instructions";

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->noship != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "noship"          => $request->noship
                    ]);

                    if ($dispatch->noship == 0)
                    $log_txt = "Changed to ship OK";
                    else $log_txt = "Changed to DO NOT ship";


                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->delivered != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "delivered"          => $request->delivered
                    ]);

                    if ($dispatch->delivered == 0)
                        $log_txt = "Marked as completed";
                    else
                        $log_txt = "Removed mark as completed";

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }
            if($request->void != ''){
                foreach($request->ids_to_edit as $id){

                    $dispatch = dispatch::find($id);

                    $change = dispatch::whereId($id)->update([
                        "void"          => $request->void
                    ]);

                    if ($dispatch->void == 0)
                        $log_txt = "Marked as completed";
                    else
                        $log_txt = "Removed mark as completed";

                    $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
                }
            }

            // Commit And Redirected To Listing
            DB::commit();
            return  redirect()->back()->with('success', 'Dispatch Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dispatch  $dispatch
     * @return \Illuminate\Http\Response
     */
    public function destroy(dispatch $dispatch)
    {
        //
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            // Delete User
            dispatch::whereId($request->dispatch_id)->delete();

            DB::commit();
            return  redirect()->back()->with('success', 'Dispatch Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function getCommoditieSuppliers()
    {
        $id = $_POST['id'];
        $suppliers = Commoditie::getsupplierofcommodity($id);
        $html = '';
        $html .= '<option value = "1">            </option>';
        foreach ($suppliers as $sup) {
            $html .= '<option value = "' . $sup->id . '">' . $sup->name . '</option>';
        }

        return $html;
    }
    public function getSuppliersExits()
    {

        $id = $_POST['id'];
        $exits = Supplier::getexitofsupplier($id);
        $html = '';
        $html .= '<option value = "1">            </option>';
        foreach ($exits as $exit) {
            $html .= '<option value = "' . $exit->id . '">' . $exit->name . '</option>';
        }

        return $html;
    }

    public function getdispatch()
    {
        date_default_timezone_set("America/Los_Angeles");

        $id = $_POST['dispatch'];
        $dispatches = dispatch::whereId($id)->get();

        $dispatches[0]['date'] = date('Y-m-d',  $dispatches[0]['date']);

        return $dispatches;
    }

    public function searchview(Request  $request)
    {
        //echo "<pre>";
        //dd($request);
        //die();
        $commodities = Commoditie::where('active', 1)->get();
        $suppliers = Supplier::where('active', 1)->get();
        $exits = Exits::where('active', 1)->get();
        $rates = rate::where('active', 1)->get();
        $vias = Via::where('active', 1)->get();
        $destinations = Destination::where('active', 1)->get();
        $users = User::where('status', 1)->get();
        $config = Config::get();


        /////////Start search

        $html = array();

        $html['datepicker_from'] = date("dMY");
        $html['datepicker_to'] =  date("dMY");
        $html['datepicker_all'] =  false;
        $html['completed'] = FALSE;
        $html['noship'] = FALSE;
        $html['voided'] = FALSE;
        $html['release_code'] = NULL;
        $html['purchase_code'] = NULL;
        $html['sales_num'] = NULL;
        $html['notes'] = NULL;
        $html['commodity'] = 1;
        $html['supplier'] = 1;
        $html['exit'] = 1;
        $html['via'] = 1;
        $html['destination'] = 1;
        $html['salesman'] = 1;
        $html['rate'] = 1;
        $html['search_string'] = NULL;
        $keys = array('datepicker_all','completed', 'noship', 'voided', 'release_code', 'purchase_code', 'sales_num', 'notes', 'commodity', 'supplier', 'exit', 'via', 'destination', 'salesman', 'rate');
        $variables = array();
        foreach ($keys as $key) {

            if ($request->$key == '') {
                $value = $html[$key];
            } else {
                $value  = $request->$key;
            }
            switch ($key) {
                case 'completed':
                    if ($value !== FALSE) $variables['delivered'] = 1;
                    break;

                case 'noship':
                    if ($value !== FALSE) $variables['noship'] = 1;
                    break;

                case 'datepicker_all':
                    if ($value !== FALSE) $variables['datepicker_all'] = 1;
                    break;

                case 'voided':
                    if ($value !== FALSE) $variables['void'] = 1;
                    break;

                case 'release_code':
                case 'purchase_code':
                case 'sales_num':
                case 'notes':
                    if ($value != NULL) $variables[$key] = $value;
                    break;

                case 'commodity':
                case 'supplier':
                case 'exit':
                case 'via':
                case 'destination':
                case 'salesman':
                case 'rate':
                    if ($value != 1) $variables[$key] = $value;
                    break;
            }
        }
        //dd($variables);

        $from =  $request->datepicker_from?? Carbon::now()->startOfDay();
        $to =  $request->datepicker_to?? Carbon::now();

        $dispatches = dispatch::get_dispatches_search($from, $to, $variables);




        return view('dispatch.index1', ['dispatches' => $dispatches,'commodities' => $commodities, 'suppliers' => $suppliers, 'exits' => $exits, 'rates' => $rates, 'vias' => $vias, 'destinations' => $destinations, 'users' => $users,'config'=>$config]);
    }

    public function searchresult(Request $request)
    {
        //dd($request);

        // set defaults
        $html = array();

        $html['datepicker_from'] = date("dMY");
        $html['datepicker_to'] =  date("dMY");
        $html['datepicker_all'] =  FALSE;
        $html['completed'] = FALSE;
        $html['noship'] = FALSE;
        $html['voided'] = 0;
        $html['release_code'] = NULL;
        $html['purchase_code'] = NULL;
        $html['sales_num'] = NULL;
        $html['notes'] = NULL;
        $html['commodity'] = 1;
        $html['supplier'] = 1;
        $html['exit'] = 1;
        $html['via'] = 1;
        $html['destination'] = 1;
        $html['salesman'] = 1;
        $html['rate'] = 1;
        $html['search_string'] = NULL;
        $keys = array('completed', 'noship', 'voided', 'release_code', 'purchase_code', 'sales_num', 'notes', 'commodity', 'supplier', 'exit', 'via', 'destination', 'salesman', 'rate');
        $variables = array();
        foreach ($keys as $key) {

            if ($request->$key == '') {
                $value = $html[$key];
            } else {
                $value  = $request->$key;
            }
            switch ($key) {
                case 'completed':
                    if ($value !== FALSE) $variables['delivered'] = 1;
                    break;

                case 'noship':
                    if ($value !== FALSE) $variables['noship'] = 1;
                    break;

                case 'voided':
                    if ($value !== FALSE) $variables['void'] = 1;
                    break;

                case 'release_code':
                case 'purchase_code':
                case 'sales_num':
                case 'notes':
                    if ($value != NULL) $variables[$key] = $value;
                    break;

                case 'commodity':
                case 'supplier':
                case 'exit':
                case 'via':
                case 'destination':
                case 'salesman':
                case 'rate':
                    if ($value != 1) $variables[$key] = $value;
                    break;
            }
        }

        $dispatches = dispatch::get_dispatches_search($request->datepicker_from, $request->datepicker_to, $variables);
        $commodities = Commoditie::where('active', 1)->get();
        $suppliers = Supplier::get();
        $exits = Exits::get();
        $rates = rate::get();
        $vias = Via::get();
        $destinations = Destination::get();
        $users = User::get();
        $config = Config::get();

        return view('dispatch.index', ['dispatches' => $dispatches, 'commodities' => $commodities, 'suppliers' => $suppliers, 'exits' => $exits, 'rates' => $rates, 'vias' => $vias, 'destinations' => $destinations, 'users' => $users,'config'=>$config]);
    }

    public function export()
    {
        return Excel::download(new DispatchesExport, 'Dispatches.xlsx');
    }

    public function changelog()
    {
        date_default_timezone_set("America/Los_Angeles");

        $id = $_POST['dispatch'];
        $dispatchlog = DispatchLog::where('dispatch_id',$id)->get();
        $html = '';
        foreach ($dispatchlog as $log) {
            $log['date'] = date('d/m/Y  h:m:s',  $log->datetime);
            $html .= '<tr class="alt"><td class="date">'.$log->date.'</td><td>'.$log->user->first_name.'</td><td>'.$log->note.'</td></tr>';
        }
        //dd($html);
        return $html;
    }

    function UpdateLogs($request,$dispatch)
    {

        $fields = array('date','commodity_id','supplier_id','purchase_code','exit_id','release_code','via_id','destination_id','rate_id','salesman_id','sales_num','sales_notes','accounting_notes','driver_instructions','completed','noship','voided');
        $data = array();
        foreach ($fields as $key=>$field)
        {
            $value = $request->$field;
            if ($field == 'date' && $value != '')
            {
                $date_r = explode("-",$value);
                echo $data['date'] = $date_r[0].'-'.$date_r[1].'-'.$date_r[2];
                $data['date'] = strtotime($data['date']);

            }
            elseif ($field == 'voided')
            {
                $data['void'] = $value;
            }
            elseif ($field == 'completed')
            {
                $data['delivered'] = $value;
            }
            else
            {
                $data[ $field ] = $value;
            }
        }
        foreach ($data as $key=>$value)
        {
            if ($dispatch->$key == $value)
            {
                unset($data[$key]);
            }
        }
       // dd($data);
        $log_txt = NULL;
		foreach ($data as $name=>$value)
		{
			if ($log_txt != NULL)
			{
				$log_txt .= "\n";
			}
			switch ($name)
			{
				case 'date':
					$date = date("m/d/Y", $value);
					$log_txt .= "Changed date to $date";
					break;

				case 'commodity_id':
					$log_txt .= "Changed commodity to {COMMODITY:$value}";
					break;

				case 'supplier_id':
					$log_txt .= "Changed supplier to {SUPPLIER:$value}";
					break;

				case 'purchase_code':
					$log_txt .= "Changed purchase code to $value";
					break;

				case 'exit_id':
					$log_txt .= "Changed exit to {EXIT:$value}";
					break;

				case 'release_code':
					$log_txt .= "Changed release code to $value";
					break;

				case 'driver_instructions':
					$log_txt .= "Changed driver instructions";
					break;

				case 'via_id':
					$log_txt .= "Changed via to {VIA:$value}";
					break;

				case 'destination_id':
					$log_txt .= "Changed destination to {DESTINATION:$value}";
					break;

				case 'rate_id':
					$log_txt .= "Changed rate to {RATE:$value}";
					break;

				case 'salesman':
					$date = date("m/d/Y", $value);
					$log_txt .= "Changed salesman to {SALESMAN:$value}";
					break;

				case 'sales_num':
					$log_txt .= "Changed sales number to $value";
					break;

				case 'sales_notes':
					$log_txt .= "Changed sales notes";
					break;

				case 'accounting_notes':
					$log_txt .= "Changed accounting notes";
					break;

				case 'noship':
					if ($value == TRUE) $log_txt .= "Changed to ship OK";
					else $log_txt .= "Changed to DO NOT ship";
					break;

				case 'void':
					if ($value == TRUE) $log_txt .= "Voided dispatch";
					else $log_txt .= "Removed VOID";
					break;

				case 'delivered':
					if ($value == TRUE) $log_txt .= "Marked as completed";
					else $log_txt .= "Removed mark as completed";
					break;
			}
		}

        $this->log_change($dispatch->id, Auth::user()->id, $log_txt);
    }


    public function log_change($dispatch_id, $user_id,$log_txt)
    {
        if($log_txt != '')
        {
            $data = array(
                'datetime'		=> time(),
                'dispatch_id'	=> $dispatch_id,
                'user_id'		=> $user_id,
                'note'			=> $log_txt
            );
            DB::table('dispatch_log')->insert($data);
        }
    }

    public function updatedelivered($id, $delivered)
    {
        // Validation
        $validate = Validator::make([
            'id'   => $id,
            'delivered'    => $delivered
        ], [
            'id'   =>  'required',
            'delivered'    =>  'required|in:0,1',
        ]);


        //dd($data);

        // If Validations Fails
        if($validate->fails()){
            return  redirect()->back()->with('error', $validate->errors()->first());
        }

        // try {
            DB::beginTransaction();

            // Update Status
            $log_txt = NULL;
            $dispatch = dispatch::find($id);

            if ($dispatch->delivered == 0)
                $log_txt .= "Marked as completed";
            else
                $log_txt .= "Removed mark as completed";


            $this->log_change($dispatch->id, Auth::user()->id, $log_txt);

            dispatch::whereId($id)->update(['delivered' => $delivered]);


            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->back()->with('success','Dispatch Delivery Status Updated Successfully!');
        // } catch (\Throwable $th) {

        //     // Rollback & Return Error Message
        //     DB::rollBack();
        //     return redirect()->back()->with('error', $th->getMessage());
        // }
    }
    public function updatenoship($id, $noship)
    {
        // Validation
        $validate = Validator::make([
            'id'        => $id,
            'noship'    => $noship
        ],[
            'id'        =>  'required',
            'noship'    =>  'required|in:0,1',
        ]);

        $data = array('noship'   => $noship);

        // If Validations Fails
        if($validate->fails()){
            return redirect()->back()->with('error', $validate->errors()->first());
        }

        try {


            DB::beginTransaction();


            $log_txt = NULL;
            $dispatch = dispatch::find($id);

            if ($dispatch->noship == 0)
            $log_txt .= "Changed to ship OK";
            else $log_txt .= "Changed to DO NOT ship";


            $this->log_change($dispatch->id, Auth::user()->id, $log_txt);

            $dispatch = dispatch::find($id);

            //$this->UpdateLogs($data,$dispatch);

            // Update noship
            dispatch::whereId($id)->update(['noship' => $noship]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->back()->with('success','Dispatch noship Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function changedisplay(){

        $value = $_POST['value'];

        session(['changedisplay' => $value]);

    }

  //////Check if realse code alreaeday  exyetedadasd

    public function GetReleaseCode(){
        $release_code = $_POST['release_code'];
        if( $release_code){
            $dispatch = Dispatch::where('release_code', $release_code)->first();
            if($dispatch){
                echo '1';
            }
            else {
                echo '0';
            }
        }
    }

}
