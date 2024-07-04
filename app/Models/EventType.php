<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function recordStatus(): BelongsTo
    {
        return $this->belongsTo(RecordStatus::class);
    }

    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }

}
