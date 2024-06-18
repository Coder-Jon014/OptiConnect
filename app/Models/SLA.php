<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLA extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_type_id',
        'max_duration',
        'compensation_details',
        'outage_history_id', // If you want to link to outage history
    ];
}