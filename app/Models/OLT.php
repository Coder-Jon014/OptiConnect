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

    // protected $primaryKey = 'olt_id';

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

    public static function boot()
    {
        parent::boot();

        static::saving(function ($olt) {
            // Calculate rank
            if ($olt->customer_count <= 5000) {
                $olt->rank = 1;
            } elseif ($olt->customer_count <= 10000) {
                $olt->rank = 2;
            } elseif ($olt->customer_count <= 15000) {
                $olt->rank = 3;
            } elseif ($olt->customer_count <= 20000) {
                $olt->rank = 4;
            } else {
                $olt->rank = 5;
            }

            // Calculate level
            if ($olt->business_customer_count > 0 && $olt->olt_value > 0) {
                $olt->level = 'High';
            } else {
                $olt->level = 'Low';
            }
        });
    }
}
