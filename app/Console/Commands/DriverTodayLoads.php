<?php

namespace App\Console\Commands;

use App\Mail\TodayDispatchesMail;
use App\Models\dispatch;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DriverTodayLoads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drivers:loads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send drivers about todays load';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $drivers = User::with('trucks')->select(['id', 'first_name', 'last_name', 'email'])->where('role_id', 4)->get();

        foreach ($drivers as $driver) {
            date_default_timezone_set("America/Phoenix");
            // $date = date('m/d/Y');
            $date = '06/28/2023';
            $date_timestamp =  strtotime($date);
            $dispatches = dispatch::query()
                ->with(['commodity', 'supplier', 'exit', 'rate', 'destination'])
                ->where('date', $date_timestamp)
                ->whereIn('via_id', $driver->trucks?->pluck('id'))
                ->get();

            if ($dispatches->count() > 0) {
                Mail::to($driver)->send(new TodayDispatchesMail($driver, $dispatches, $date));
            }
        }

        $this->info("Today's dispatches mails reminder has been send");
    }
}
