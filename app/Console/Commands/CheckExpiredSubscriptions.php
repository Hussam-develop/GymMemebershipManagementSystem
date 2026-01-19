<?php

namespace App\Console\Commands;

use App\Jobs\ProcessExpiredSubscriptionsJob;
use App\Jobs\ProcessExpiringSoonSubscriptionsJob;
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


        // Dispatch job to process expired subscriptions
        dispatch(new ProcessExpiredSubscriptionsJob());
        // Dispatch job to process expiring soon subscriptions
        dispatch(new ProcessExpiringSoonSubscriptionsJob(3));
    }
}
