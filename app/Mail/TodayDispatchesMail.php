<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class TodayDispatchesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $driver, $dispatches, $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($driver, $dispatches, $date)
    {
        $this->driver = $driver;
        $this->dispatches = $dispatches;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('app.name'))
            ->subject("Today's Dispatches")
            ->view('mails.today-dispatches', [
                'driver' => $this->driver,
                'dispatches' => $this->dispatches,
                'date' => $this->date,
            ]);
    }
}
