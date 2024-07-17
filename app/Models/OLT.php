<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Parish;
use App\Models\Town;
use App\Models\Resource;

class OLT extends Model
{
    use HasFactory;

    protected $table = 'olts'; // Ensure this matches the table name in the migration

    protected $primaryKey = 'olt_id';

    protected $fillable = [
        'olt_name',
        'parish_id',
        'town_id',
        'customer_count',
        'business_customer_count',
        'residential_customer_count',
        'resource_id',
        'olt_value',
        'rank',
        'level'
    ];

    public function parish()
    {
        return $this->belongsTo(Parish::class, 'parish_id', 'parish_id');
    }

    public function town()
    {
        return $this->belongsTo(Town::class, 'town_id');
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id', 'resource_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'town_id', 'town_id');
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($olt) {
            // Calculate level
            $olt->level = ($olt->business_customer_count >= 800) ? 'High' : 'Low';
        });
    }
}
