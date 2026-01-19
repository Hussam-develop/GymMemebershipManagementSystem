<?php

namespace App\Console\Commands;

use App\Notifications\SubscriptionExpiringSoon;
use App\Services\SubscriptionService;
use Illuminate\Console\Command;

class CheckExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark expired subscriptions and notify expiring ones';

    public function __construct(private SubscriptionService $subscriptionService)
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get expired subscriptions by subscription_end_date
        $expired = $this->subscriptionService->getExpired();
        foreach ($expired as $subscription) {
            // update subscription status to Expired
            $this->subscriptionService->markExpired($subscription);
        }
        //get Subscriptions Expiring Soon by days
        $expiring = $this->subscriptionService->getExpiringSoon(3);
        foreach ($expiring as $subscription) {
            // notify members
            $subscription->member->notify(new SubscriptionExpiringSoon($subscription));
        }
    }
}
