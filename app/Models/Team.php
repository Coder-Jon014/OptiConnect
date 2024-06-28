<?php

namespace App\Models;
// app/Models/Team.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $primaryKey = 'team_id';

    protected $fillable = [
        'team_name',
        'team_type',
        // 'resource_name',
    ];

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'resource_team', 'team_id', 'resource_id');
    }

    public function outageHistories()
    {
        return $this->hasMany(OutageHistory::class, 'team_id');
    }
}

