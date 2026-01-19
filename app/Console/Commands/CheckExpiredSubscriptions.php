<?php

namespace App\Console\Commands;

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
        $expired = $this->subscriptionService->getExpired();
        foreach ($expired as $subscription) {
            $this->subscriptionService->markExpired($subscription);
        }
        $this->subscriptionService->notifyExpiringSoon(3);
        $this->info('Expired subscriptions updated and expiring notifications sent.');


        $expiring = $this->subscriptionService->getExpiringSoon(3);
        foreach ($expiring as $subscription) {
            $subscription->member->notify(new SubscriptionExpiringSoonNotification($subscription));
        }
    }
}
