<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Subscription extends Model
{
        use HasFactory;

    protected $fillable = [
        'member_id',
        'plan_id',
        'subscription_start_date',
        'subscription_end_date',
        'is_paid',
        'status',
    ];

    protected $casts = [
        'status' => StatusEnum::class,
        'subscription_start_date' => 'date',
        'subscription_end_date' => 'date',
        'is_paid' => 'boolean',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', StatusEnum::Active->value)->where('is_paid', true)->whereDate('subscription_end_date', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('status', StatusEnum::Expired->value)->orWhereDate('subscription_end_date', '<', now());
    }

    public function isExpired(): bool
    {
        return $this->subscription_end_date->lt(Carbon::now()) || $this->status === StatusEnum::Expired->value;
    }
}
