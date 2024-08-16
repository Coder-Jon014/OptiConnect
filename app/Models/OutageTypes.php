<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutageTypes extends Model
{
    use HasFactory;

    protected $primaryKey = 'outage_type_id';
    protected $fillable = [
        'outage_type_name',
        'resource_id',
    ];

    public function outageHistories()
    {
        return $this->hasMany(OutageHistory::class, 'outage_type_id');
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'outage_type_resources', 'outage_type_id', 'resource_id');
    }
}
