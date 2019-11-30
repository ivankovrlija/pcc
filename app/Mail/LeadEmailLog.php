<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\LeadLog;

class LeadEmailLog extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(LeadLog $log)
    {
        $this->log = $log;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->log->email_fromemail, $this->log->email_fromname)
            ->subject($this->log->email_subject)
            ->view('emails.lead')
            ->with([
                'name'    => $this->log->email_name,
                'content' => $this->log->email_message
            ]);
    }
}
