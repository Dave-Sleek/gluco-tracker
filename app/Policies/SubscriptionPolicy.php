<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Subscription;

class SubscriptionPolicy
{
    public function view(User $user, Subscription $subscription): bool
    {
        return $user->id === $subscription->user_id;
    }

    public function update(User $user, Subscription $subscription): bool
    {
        return $user->id === $subscription->user_id;
    }

    public function delete(User $user, Subscription $subscription): bool
    {
        return $user->id === $subscription->user_id;
    }
}
