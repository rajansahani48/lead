<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionHistory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="transaction_history";
    protected $fillable = [
        'telecaller_id',
        'campaign_id',
        'lead_id',
        'amount',
    ];

    public function campaignName()
    {
        return $this->belongsTo(Campaign::class,'campaign_id','id');
    }
}
