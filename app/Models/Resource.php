<?php

namespace App\Models;

// app/Models/Resource.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Resource extends Model
{
    use HasFactory;

    protected $primaryKey = 'resource_id';

    protected $fillable = [
        'resource_name',
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'resource_team', 'resource_id', 'team_id');
    }

    public function olts()
    {
        return $this->hasMany(OLT::class, 'resource_id', 'resource_id');
    }
}
