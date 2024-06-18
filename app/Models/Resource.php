<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = ['resource_name'];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'resource_team');
    }
}