<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'name',
        'description',
        'exchange',
        'history',
    ];

    /**
     * Get the investments of the current share.
     */
    public function investments() {
        return $this->hasMany('App\Models\Investment', 'share_id', 'id');
    }
}
