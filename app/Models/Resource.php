<?php

namespace App\Models;

// app/Models/Resource.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $primaryKey = 'resource_id'; // Ensure this matches the primary key column in the migration

    protected $fillable = [
        'resource_name',
    ];

    public function teams()
    {
        return $this->hasMany(Team::class, 'resource_id', 'resource_id');
    }
}
