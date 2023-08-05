<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\Config;
use App\Models\dispatch;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Services\CalendarService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (!$request->user()->hasRole('truck')) {
            $data = $this->calculations($request);
            $months = $data['months'];
            $years = $data['years'];
            $fromDate = $data['from_date'];
            $toDate = $data['to_date'];

            // get total commision earned
            // $data['commission'] = $data['commission'];
            // if ($data['load_shipped'] > 4000) {
            //     $extra_load = $data['load_shipped'] - 4000;
            //     $data['commission'] = $extra_load * 0.5;
            // }
            // $total_dispatched = dispatch::query()
            //     ->with('rate')
            //     ->select('rate_id')
            //     ->when($request->user()->hasRole('salesman'), fn ($q) => $q->where('salesman', auth()->id()))
            //     ->where('date', '>=', $fromDate->timestamp)
            //     ->where('date', '<=', $toDate->timestamp)
            //     ->whereNotNull('rate_id')
            //     ->get();
            // $data['commission'] = 0;
            // foreach ($total_dispatched as $item) {
            //     $data['commission'] +=  (float) str_replace('$', '', $item->rate?->name);
            // }

            // get scorboard
            // $data['sales_records'] = dispatch::query()
            //     ->with('salesman1:id,first_name,last_name')
            //     ->select('salesman', DB::raw('count(*) as total_loads'))
            //     // ->when($request->user()->hasRole('salesman'), fn ($q) => $q->where('salesman', auth()->id()))
            //     ->where('date', '>=', $fromDate->timestamp)
            //     ->where('date', '<=', $toDate->timestamp)
            //     ->groupBy('salesman')
            //     ->orderBy('total_loads', 'DESC')
            //     ->get();

            // $salesmans = [];
            // $salesman_scores = [];
            // foreach ($data['sales_records'] as $record) {
            //     $salesmans[] = $record->salesman1?->full_name;
            //     $salesman_scores[] = str_replace('.00', '', number_format($record->total_loads * 24, 2));
            // }


            // // get top 5 products
            // $data['top_products'] = dispatch::query()
            //     ->with('commodity')
            //     ->select('commodity_id', DB::raw('count(*) as total_loads'))
            //     ->when($request->user()->hasRole('salesman'), fn ($q) => $q->where('salesman', auth()->id()))
            //     ->where('date', '>=', $fromDate->timestamp)
            //     ->where('date', '<=', $toDate->timestamp)
            //     ->groupBy('commodity_id')
            //     ->orderBy('total_loads', 'DESC')
            //     ->take(5)
            //     ->get();

            // $top_products = [];
            // $top_products_scores = [];

            // foreach ($data['top_products'] as $record) {
            //     $top_products[] = $record->commodity?->name ?? $record->commodity_id;
            //     $top_products_scores[] = str_replace('.00', '', number_format($record->total_loads * 24, 2));
            // }
        }

        if ($request->user()->hasRole('truck')) {
            $bulletins = Bulletin::doesntHave('read')->whereStatus(true)->latest()->get();
        } else {
            $bulletins = [];
        }

        $strFromDate = date("Y-m-d");
        $strToDate = date("Y-m-d");
        $data['dispatches'] = dispatch::get_dispatches_search($strFromDate, $strToDate, [], ['release_code', 'noship', 'void', 'delivered', 'commodity_id', 'destination_id', 'rate_id']);

        return view('home', compact('data', 'bulletins'));
    }

    public function home_ajax(Request $request)
    {
        $data = $this->calculations($request);

        return response()->json(
            [
                'loads' => $data['loads'],
                'load_dates' => $data['load_dates'],
                'commissions' => $data['commissions'],
                'commissions_dates' => $data['commissions_dates'],
                'salesmans' => $data['salesmans'],
                'salesman_scores' => $data['salesman_scores'],
                'top_products' => $data['top_products'],
                'top_products_scores' => $data['top_products_scores'],
            ]
        );
    }

    /**
     * Read the bulliton.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function readBulletin(Bulletin $bulletin)
    {
        $bulletin->reads()->create([
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    /**
     * User Profile
     * @param Nill
     * @return View Profile
     * @author Shani Singh
     */
    public function getProfile()
    {
        return view('profile');
    }

    /**
     * Update Profile
     * @param $profileData
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function updateProfile(Request $request)
    {
        #Validations
        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'mobile_number' => 'required|numeric|digits:10',
        ]);

        try {
            DB::beginTransaction();

            #Update Profile Data
            User::whereId(auth()->user()->id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_number' => $request->mobile_number,
            ]);

            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Profile Updated Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Change Password
     * @param Old Password, New Password, Confirm New Password
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        try {
            DB::beginTransaction();

            #Update Password
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Password Changed Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    private function calculations($request)
    {
        $ton = (int) Config::where('item', 'ton')->first()?->value ?? 25;

        date_default_timezone_set("America/Los_Angeles");
        // get months
        $data['months'] = CalendarService::months();

        // get oldest record years list to current year
        $data['years'] = CalendarService::years();
        if ($request->from_month && !is_null($request->from_month) && in_array($request->from_month, $data['months'])) {
            $month = (int)CalendarService::getMonth($request->from_month) + 1;
            $month_start_date = date('Y') . '-' . $month . '-1';
            $fromDate = Carbon::createFromFormat('Y-m-d',  $month_start_date)->startOfDay();
            $toDate = Carbon::createFromFormat('Y-m-d',  $month_start_date)->endOfMonth();
        } else if ($request->from_year && !is_null($request->from_year) && in_array($request->from_year, $data['years'])) {
            $year_start_date = $request->from_year . '-01-01';
            $fromDate = Carbon::createFromFormat('Y-m-d',  $year_start_date)->startOfDay();
            $toDate = now()->endOfDay();
        } else {
            $fromDate = now()->startOfMonth();
            $toDate = now()->endOfDay();
        }

        $tons_shipped = dispatch::query()
            ->groupBy('date')
            ->select(DB::raw("DATE_FORMAT(FROM_UNIXTIME(`date`), '%d %M %Y') as datetime"), DB::raw('count(*) as total'))
            ->when($request->user()->hasRole('salesman'), fn ($q) => $q->where('salesman', auth()->id()))
            ->where('date', '>=', $fromDate->timestamp)
            ->where('date', '<=', $toDate->timestamp)
            ->get();

        $data['loads'] = [];
        $data['total_loads'] = 0;
        $data['load_dates'] = [];
        foreach ($tons_shipped as $item) {
            $data['loads'][] = $item->total * $ton;
            $data['total_loads'] += $item->total;
            $data['load_dates'][] = $item->datetime;
        }
        $load_shipped = $data['total_loads'] * $ton;

        // commissions
        $query_for_commission = dispatch::query()
            ->groupBy('date')
            ->select(['salesman', DB::raw('count(id) as total'), DB::raw("DATE_FORMAT(FROM_UNIXTIME(`date`), '%M %Y') as duration")])
            ->when($request->user()->hasRole('salesman'), fn ($q) => $q->where('salesman', auth()->id()))
            ->where('date', '>=', $fromDate->timestamp)
            ->where('date', '<=', $toDate->timestamp)
            // ->whereNotNull('salesman')
            ->groupBy('salesman')
            ->groupBy('duration')
            ->orderBy('duration')
            ->get()
            ->groupBy('duration');

        $total  = 0;
        $data['commission'] = 0;
        $data['commissions'] = [];
        $data['commissions_dates'] = [];
        foreach ($query_for_commission as $month_name => $month) {
            $data['commissions_dates'][] = $month_name;

            $salesmans = $month->groupBy('salesman');
            $month_total_commission = 0;
            foreach ($salesmans as $saleman) {
                $salesman_total_shipped = 0;
                foreach ($saleman as $id => $record) {
                    $salesman_total_shipped += $record->total;
                }
                $salesman_ton_shipped = $salesman_total_shipped * 24;
                // saleman month commission
                if ($salesman_ton_shipped > 4000) {
                    $extra_load = $salesman_ton_shipped - 4000;
                    $commission = $extra_load * 0.5;
                } else {
                    $extra_load = 0;
                    $commission = 0;
                }

                $month_total_commission += $commission;
                $total += $salesman_ton_shipped;
                // dump('Month: ' . $month_name . ' SalemanId:' . $id . ' shipped: ' . $salesman_ton_shipped . ' extra: ' . $extra_load . ' commission: ' . $commission);
            }
            $data['commissions'][] = $month_total_commission;
            $data['commission'] += $month_total_commission;
            // dump('Month: ' . $month_name . ' Commission:' . $month_total_commission);
        }

        // dd($data['commission'], $data['commissions'], $data['commissions_dates']);

        // scoreboard
        $data['sales_records'] = dispatch::query()
            ->with('salesman1:id,first_name,last_name')
            ->select('salesman', DB::raw('count(*) as total_loads'))
            // ->when($request->user()->hasRole('salesman'), fn ($q) => $q->where('salesman', auth()->id()))
            ->where('date', '>=', $fromDate->timestamp)
            ->where('date', '<=', $toDate->timestamp)
            ->groupBy('salesman')
            ->orderBy('total_loads', 'DESC')
            ->get();

        $salesmans = [];
        $salesman_scores = [];
        foreach ($data['sales_records'] as $record) {
            $salesmans[] = $record->salesman1?->full_name ?? 'Unknown';
            $salesman_scores[] = $record->total_loads * 24;
        }


        // get top 5 products
        $data['top_products'] = dispatch::query()
            ->with('commodity')
            ->select('commodity_id', DB::raw('count(*) as total_loads'))
            ->when($request->user()->hasRole('salesman'), fn ($q) => $q->where('salesman', auth()->id()))
            ->where('date', '>=', $fromDate->timestamp)
            ->where('date', '<=', $toDate->timestamp)
            ->groupBy('commodity_id')
            ->orderBy('total_loads', 'DESC')
            ->take(5)
            ->get();

        $top_products = [];
        $top_products_scores = [];

        foreach ($data['top_products'] as $record) {
            $top_products[] = $record->commodity?->name ?? $record->commodity_id;
            $top_products_scores[] = $record->total_loads * 24;
        }

        return [
            'load_shipped' =>  $load_shipped,
            'loads' => $data['loads'],
            'load_dates' => $data['load_dates'],
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'months' => $data['months'],
            'years' => $data['years'],
            'commission' => $data['commission'],
            'commissions' => $data['commissions'],
            'commissions_dates' => $data['commissions_dates'],
            'salesmans' => $salesmans,
            'salesman_scores' => $salesman_scores,
            'top_products' => $top_products,
            'top_products_scores' => $top_products_scores,
        ];
    }
}
