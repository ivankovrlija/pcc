<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Email;
use App\Campaign;
use App\Lead;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $lead, $campaign, $subject_line;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign, Lead $lead, Email $email)
    {
        $this->lead         = $lead;
        $this->campaign     = $campaign;
        $this->template     = $email->html;
        $this->templateCSS  = $email->css;
        $this->subject_line = $this->campaign->subject_line;

        $this->subject_line = str_replace('{FNAME}', $this->lead->first_name, $this->subject_line);
        $this->subject_line = str_replace('{LNAME}', $this->lead->last_name, $this->subject_line);
        $this->subject_line = str_replace('{EMAIL}', $this->lead->email, $this->subject_line);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->campaign->from_email, $this->campaign->from_name)
            ->subject($this->subject_line)
            ->replyTo($this->campaign->reply_to)
            ->view('emails.note')
            ->with([
                'template'    => $this->template,
                'templateCSS' => $this->templateCSS,
                'lead'        => $this->lead
            ]);
    }
}
