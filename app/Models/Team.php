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
        'resource_id', // Ensure this is included in the fillable properties
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id', 'resource_id');
    }

    public function outageHistories()
    {
        return $this->hasMany(OutageHistory::class, 'team_id');
    }
}

