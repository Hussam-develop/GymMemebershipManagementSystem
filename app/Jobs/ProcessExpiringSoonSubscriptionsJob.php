<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessExpiringSoonSubscriptionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $days) {}

    /**
     * Execute the job.
     */
    public function handle()
    {
        $service = app(\App\Services\SubscriptionService::class);
          //get Subscriptions Expiring Soon by days

        $expiring = $service->getExpiringSoon($this->days);
        foreach ($expiring as $subscription) {
            // notify members

            $subscription->member->notify(new \App\Notifications\SubscriptionExpiringSoon($subscription));
        }
    }
}
