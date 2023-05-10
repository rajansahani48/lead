<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="campaigns";
    protected $fillable = [
        'campaign_name',
        'campaign_desc',
        'cost_per_lead',
        'conversion_cost',
    ];

    //campaign has many telecaller
    public function CampaignHasUser()
    {
        return $this->belongsToMany(User::class,'usercampaign','campaign_id','telecaller_id','id');
    }

    //one campagin has many leads
    public function hasManyLeads()
     {
        return $this->hasMany(Lead::class,'campaign_id','id');
    }

    //campaign have pending leads
    public function PendingLeads()
    {
        return $this->hasMany(Lead::class,'campaign_id','id')->whereNotIn('status', ['converted'])->where(function($q){
            if(!empty(request('startDate')))
                $q->where('updated_at', '>=',request('startDate'). " 00:00:00")->where('updated_at', '<=', request('endDate'). " 23:59:59");
        });
    }

    //campaign have in progress leads
    public function inProgressLeads()
    {
        return $this->hasMany(Lead::class,'campaign_id','id')->where('status', 'in progress')->where(function($q){
            if(!empty(request('startDate')))
                $q->where('updated_at', '>=',request('startDate'). " 00:00:00")->where('updated_at', '<=', request('endDate'). " 23:59:59");
        });
    }

    //campaign have in on hold leads
    public function onHoldLeads()
    {
        return $this->hasMany(Lead::class,'campaign_id','id')->where('status', 'on hold')->where(function($q){
            if(!empty(request('startDate')))
                $q->where('updated_at', '>=',request('startDate'). " 00:00:00")->where('updated_at', '<=', request('endDate'). " 23:59:59");
        });
    }
    //campaign have pending leads
    public function ProccedLeads()
    {
        return $this->hasMany(Lead::class,'campaign_id','id')->where('status', 'converted')->where(function($q){
            if(!empty(request('startDate')))
                $q->where('updated_at', '>=',request('startDate'). " 00:00:00")->where('updated_at', '<=', request('endDate'). " 23:59:59");
        });
    }
}
