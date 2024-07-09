<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    use HasFactory;
    protected $primaryKey = 'customer_type_id'; // Custom primary key

    protected $fillable = [
        'customer_type_name',
        'customer_value',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function slas()
    {
        return $this->hasMany(SLA::class);
    }
}