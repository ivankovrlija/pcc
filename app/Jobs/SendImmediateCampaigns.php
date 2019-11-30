<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Campaign;
use App\Email;
use App\Mail\CampaignMail;

class SendImmediateCampaigns implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = Email::find($this->campaign->email_template);

        foreach ($this->campaign->leads as $lead) {
            Mail::to($lead->email)->send(new CampaignMail($this->campaign, $lead, $email));
        }

        $this->campaign->sent = true;
        $this->campaign->save();
    }
}
