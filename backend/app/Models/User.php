<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's transactions.
     */
    public function transactions() {
        return $this->hasMany('App\Models\Transaction', 'user_id', 'id');
    }

    /**
     * Get the user's categories.
     */
    public function categories() {
        return $this->hasMany('App\Models\Category', 'user_id', 'id');
    }

    /**
     * Get the user's stock investments.
     */
    public function investments() {
        return $this->hasMany('App\Models\Investment', 'user_id', 'id');
    }
}
