<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLA extends Model
{
    use HasFactory;

    protected $table = 'slas'; // Ensure this matches the table name in the migration

    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_type_id',
        'max_duration',
        'compensation_details',
        'outage_history_id',
        'refund_amount',
        'team_id'
    ];

    public function outageHistory()
    {
        return $this->belongsTo(OutageHistory::class, 'outage_history_id');
    }

    public function customerType()
    {
        return $this->belongsTo(CustomerType::class, 'customer_type_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
