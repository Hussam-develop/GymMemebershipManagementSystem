<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status'
    ];

    protected $casts = [
        'status' => StatusEnum::class,
    ];

    // all subscriptions

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // current subscription
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', StatusEnum::Active)
            ->where('is_paid', true)
            ->whereDate('subscription_end_date', '>=', Carbon::now());
    }

    // filter active member
    public function scopeActive($query)
    {
        return $query->where('status', StatusEnum::Active);
    }

    // filter expired member
    public function scopeExpired($query)
    {
        return $query->where('status', StatusEnum::Expired);
    }
}
