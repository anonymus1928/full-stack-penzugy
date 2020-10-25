<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'name',
        'description',
        'due',
    ];

    /**
     * Get the user of the transaction.
     */
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Get the categories applied to the current transaction.
     */
    public function categories() {
        return $this->belongsToMany('App\Models\Category', 'category_transaction', 'transaction_id', 'category_id');
    }
}
