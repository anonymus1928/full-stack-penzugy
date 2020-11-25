<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'user_id',
        'deleted_at',
        'pivot',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user of the category.
     */
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Get the transactions applied to the current category.
     */
    public function transactions() {
        return $this->belongsToMany('App\Models\Transaction', 'category_transaction', 'category_id', 'transaction_id');
    }
}
