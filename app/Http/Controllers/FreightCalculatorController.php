<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Destination;
use App\Models\Exits;
use App\Models\LocationTier;
use Illuminate\Http\Request;

class FreightCalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exits = Exits::where('name', '!=', '')->where('address', '!=', '')->whereNotNull('address')->get();
        $destinations = Destination::where('name', '!=', '')->where('address', '!=', '')->whereNotNull('address')->get();

        return view('freight.index', compact('exits', 'destinations'));
    }

    /**
     * Calculated the value.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calculations(Request $request)
    {
        $miles = (float)$request->miles;
        if ($miles < 200) {
            $slot = LocationTier::where('starting', '<=', $miles)->where('ending', '>=', $miles)->first();
            $local_rate = $slot?->price ?? 0;
            $shell = (int) Config::where('item', 'shell')->first()?->value ?? 1;
            $shel_rate =  round(($local_rate * 24) / $shell);
            $local_rate = '$' . (string)$local_rate;
            $shel_rate =  '$' . (string)$shel_rate;
        } else {
            $local_rate = 'N/A';
            $shel_rate = 'N/A';
        }

        $long = LocationTier::where('name', 'location 11')->first() ?? LocationTier::last();
        $ohd = (float) Config::where('item', 'ohd')->first()?->value ?? 1;
        $long_rate =  round(($miles * $long->price / 24), 1);

        return response()->json([
            'miles' => $miles,
            'local_rate' => $local_rate,
            'shel_rate' => $shel_rate,
            'long_rate' => '$' . $long_rate,
        ]);
    }
}
