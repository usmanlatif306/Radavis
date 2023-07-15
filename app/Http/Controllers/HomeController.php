<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
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
            date_default_timezone_set("America/Los_Angeles");
            // get months
            $data['months'] = CalendarService::months();

            // get oldest record years list to current year
            $data['years'] = CalendarService::years();

            if ($request->from_month && !is_null($request->from_month) && in_array($request->from_month, $data['months'])) {
                $month = (int)CalendarService::getMonth($request->from_month) + 1;
                $month_start_date = date('Y') . '-' . $month . '-1';
                $fromDate = Carbon::createFromFormat('Y-m-d',  $month_start_date)->startOfDay();
                $toDate = Carbon::createFromFormat('Y-m-d',  $month_start_date)->endOfDay();
            } else if ($request->from_year && !is_null($request->from_year) && in_array($request->from_year, $data['years'])) {
                $year_start_date = $request->from_year . '-01-01';
                $fromDate = Carbon::createFromFormat('Y-m-d',  $year_start_date)->startOfDay();
                $toDate = now()->endOfDay();
            } else {
                $fromDate = now()->startOfMonth();
                $toDate = now()->endOfDay();
            }

            // get total load shipped
            $data['load_shipped'] = dispatch::query()
                ->when($request->user()->hasRole('salesman'), fn ($q) => $q->where('salesman', auth()->id()))
                ->where('date', '>=', $fromDate->timestamp)
                ->where('date', '<=', $toDate->timestamp)
                ->count() * 24;

            // get total commision earned
            $total_dispatched = dispatch::query()
                ->with('rate')
                ->select('rate_id')
                ->when($request->user()->hasRole('salesman'), fn ($q) => $q->where('salesman', auth()->id()))
                ->where('date', '>=', $fromDate->timestamp)
                ->where('date', '<=', $toDate->timestamp)
                ->whereNotNull('rate_id')
                ->get();
            $data['commission'] = 0;
            foreach ($total_dispatched as $item) {
                $data['commission'] +=  (float) str_replace('$', '', $item->rate?->name);
            }

            // get scorboard
            $data['sales_records'] = dispatch::query()
                ->with('salesman1:id,first_name,last_name')
                ->select('salesman', DB::raw('count(*) as total_loads'))
                ->when($request->user()->hasRole('salesman'), fn ($q) => $q->where('salesman', auth()->id()))
                ->where('date', '>=', $fromDate->timestamp)
                ->where('date', '<=', $toDate->timestamp)
                ->groupBy('salesman')
                ->orderBy('total_loads', 'DESC')
                ->get();

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
        }

        if ($request->user()->hasRole('truck')) {
            $bulletin = Bulletin::doesntHave('read')->first();
        } else {
            $bulletin = [];
        }

        $strFromDate = date("Y-m-d");
        $strToDate = date("Y-m-d");
        $data['dispatches'] = dispatch::get_dispatches_search($strFromDate, $strToDate, [], ['release_code', 'noship', 'void', 'delivered', 'commodity_id', 'destination_id', 'rate_id']);

        return view('home', compact('data', 'bulletin'));
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
}
