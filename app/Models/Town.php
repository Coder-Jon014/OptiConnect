<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    use HasFactory;

    protected $primaryKey = 'town_id'; // Custom primary key

    protected $fillable = [
        'name',
        'parish_id',
    ];

    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }
}
