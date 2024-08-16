<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutageHistory extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'olt_id',
        'outage_type_id',
        'team_id',
        'start_time',
        'end_time',
        'duration',
        'resolution_details',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Define the relationship with OLT
    public function olt()
    {
        return $this->belongsTo(OLT::class, 'olt_id');
    }

    // Define the relationship with Team
    public function team()
{
    return $this->belongsTo(Team::class, 'team_id', 'team_id');
}


    public function sla()
    {
        return $this->hasOne(SLA::class, 'outage_history_id');
    }

    public function outageType()
    {
        return $this->belongsTo(OutageTypes::class, 'outage_type_id');
    }
}
