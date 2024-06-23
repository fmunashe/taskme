<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserProfile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function references(): HasMany
    {
        return $this->hasMany(Reference::class);
    }

    public function healthConditions(): HasMany
    {
        return $this->hasMany(HealthCondition::class);
    }

    public function disabilities(): HasMany
    {
        return $this->hasMany(Disability::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function relatives(): HasMany
    {
        return $this->hasMany(NextOfKin::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
