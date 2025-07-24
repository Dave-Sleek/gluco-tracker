<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Subscription;
use App\Policies\SubscriptionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        Subscription::class => SubscriptionPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Optional: define gates or additional boot logic
    }
}
