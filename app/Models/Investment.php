<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'is_stock_share',
        'amount',
        'due_year',
        'interest',
    ];

    /**
     * Get the user of the investment.
     */
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Get the share of the current investment.
     */
    public function share() {
        return $this->belongsTo('App\Models\Share', 'share_id', 'id');
    }
}
