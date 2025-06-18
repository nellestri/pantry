<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FoodItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category', 
        'quantity',
        'unit',
        'expiry_date',
        'notes',
        'original_quantity'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'quantity' => 'decimal:2',
        'original_quantity' => 'decimal:2'
    ];

    // Relationships
    public function transactions()
    {
        return $this->hasMany(FoodTransaction::class);
    }

    // Check if item is expired
    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    // Check if item expires soon (within 7 days)
    public function expiresSoon()
    {
        return $this->expiry_date && 
               $this->expiry_date->between(now(), now()->addWeek()) &&
               !$this->isExpired();
    }

    // Get expiry status for display
    public function getExpiryStatus()
    {
        if (!$this->expiry_date) {
            return ['status' => 'no-expiry', 'text' => 'No expiry date', 'class' => 'expiry-good'];
        }

        if ($this->isExpired()) {
            return [
                'status' => 'expired', 
                'text' => 'Expired ' . $this->expiry_date->diffForHumans(), 
                'class' => 'expiry-danger'
            ];
        }

        if ($this->expiresSoon()) {
            return [
                'status' => 'warning', 
                'text' => 'Expires ' . $this->expiry_date->diffForHumans(), 
                'class' => 'expiry-warning'
            ];
        }

        return [
            'status' => 'good', 
            'text' => 'Expires ' . $this->expiry_date->format('M d, Y'), 
            'class' => 'expiry-good'
        ];
    }

    // Get quantity percentage remaining
    public function getQuantityPercentage()
    {
        if ($this->original_quantity <= 0) return 100;
        return ($this->quantity / $this->original_quantity) * 100;
    }
}