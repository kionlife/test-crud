<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Achievement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employee(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'achievement_employees');
    }
}
