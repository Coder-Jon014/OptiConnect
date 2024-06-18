<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Town;

class Parish extends Model
{
    use HasFactory;

    protected $fillable = [
        'parish_name',
    ];

    public function towns()
    {
        return $this->hasMany(Town::class);
    }
}