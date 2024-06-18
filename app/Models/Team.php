<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['team_name', 'team_type'];

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'resource_team');
    }
}
