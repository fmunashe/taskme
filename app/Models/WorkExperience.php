<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkExperience extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function profile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class);
    }

    public function duties(): HasMany
    {
        return $this->hasMany(WorkDuty::class);
    }
}
