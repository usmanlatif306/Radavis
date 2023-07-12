<?php

namespace App\Http\Controllers;

use App\Models\Via;
use Illuminate\Http\Request;

class TruckDirectoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $status = $request->status === 'inactive' ? 0 : 1;
        $trucks = Via::with('user:id,first_name,last_name,email')->where('active', $status)->get();

        return view('truck_directory.index', compact('trucks'));
    }
}
