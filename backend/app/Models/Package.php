<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
        'price',
        'paypal_plan_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getDurationTextAttribute()
    {
        switch ($this->duration) {
            case 'month':
                return 'Monthly';
            case 'year':
                return 'Yearly';
            case 'lifetime':
                return 'Lifetime';
            default:
                return ucfirst($this->duration);
        }
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function isLifetime()
    {
        return $this->duration === 'lifetime';
    }
}