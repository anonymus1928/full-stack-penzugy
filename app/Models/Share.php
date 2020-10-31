<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Share extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'symbol',
        'name',
        'description',
        'exchange',
        'history',
        'currency',
        'country',
        'sector',
        'industry',
        'address',
        'full_time_employees',
        'market_capitalization',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Get the investments of the current share.
     */
    public function investments() {
        return $this->hasMany('App\Models\Investment', 'share_id', 'id');
    }
}
