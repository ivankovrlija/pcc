<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Campaign;
use App\Email;
use App\Mail\CampaignMail;

class SendScheduledCampaigns implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaigns = Campaign::where([
            ['sent', '=', false],
            ['publish_date', '<', Carbon::now()]
        ])->get();

        foreach ($campaigns as $campaign) {
            $email = Email::find($campaign->email_template);

            foreach ($campaign->leads as $lead) {
                Mail::to($lead->email)->send(new CampaignMail($campaign, $lead, $email));
            }

            $campaign->sent = true;
            $campaign->save();
        }
    }
}
