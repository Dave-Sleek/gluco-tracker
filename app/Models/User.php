<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\MealPlan;



class User extends Authenticatable implements MustVerifyEmail
{

    use HasFactory, Notifiable;
    use HasPushSubscriptions;



    protected $fillable = [
        'full_name',
        'email',
        'profile_image',
        'password',
        'dob',
        'phone',
        'is_admin',
        'is_banned',
        'payment_status',
        'is_subscribed',
        'subscribed_at',
        'trial_start_date',
        'trial_expired',
        'has_paid',
        'device_toke',
        'meal_preference',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_banned' => 'boolean',
        'dob' => 'date',
        'is_subscribed' => 'boolean',
        'has_paid' => 'boolean',
        'subscribed_at' => 'datetime',
        'trial_start_date' => 'datetime',
        'trial_expired' => 'datetime',
        'created_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];


    public function routeNotificationForFcm()
    {
        return $this->device_token;
    }

    public function conversions()
    {
        return $this->hasMany(\App\Models\Conversion::class);
    }

    // Relationships
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Check if user's trial is active
    public function isTrialActive()
    {
        return $this->trial_expired && now()->lessThan($this->trial_expired);
    }

    // Check if user is fully subscribed
    public function isFullySubscribed()
    {
        return $this->is_subscribed && $this->subscribed_at && now()->lessThan($this->subscribed_at->addMonth());
    }

    // Meal Plan
    // public function meal()
    // {
    //     return $this->belongsTo(Meal::class);
    // }


    public function mealPlans()
    {
        return $this->hasMany(MealPlan::class);
    }


    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image
            ? asset('storage/' . $this->profile_image)
            : asset('default-avatar.png');
    }
}
