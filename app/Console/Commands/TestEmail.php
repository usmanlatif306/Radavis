<?php

namespace App\Console\Commands;

use App\Notifications\TestEmailNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send test email';

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
        Notification::route('mail', 'usmanlatif603@gmail.com')
            ->notify(new TestEmailNotification());
    }
}
