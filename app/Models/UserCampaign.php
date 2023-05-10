<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCampaign extends Model
{
    use HasFactory;
    protected $table="usercampaign";
    protected $fillable = [
        'campaign_id',
        'telecaller_id',
    ];

    //telecaller belogns to which campaign
    public function user()
    {
        return $this->belongsTo(User::class,'telecaller_id','id');
    }
}
