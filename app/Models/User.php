<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table="users";
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'country_code',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    //one telecaller can work in multiple campaign
    public function userHasCampaign()
    {
        return $this->belongsToMany(Campaign::class,'usercampaign','campaign_id','telecaller_id','id');
    }

    //one telecaller have many leads
    public function telecallerHasManyLeads()
    {
        return $this->hasManyThrough(leads::class, usercampaign::class,'telecaller_id','campaign_id','id','id');
    }
}
