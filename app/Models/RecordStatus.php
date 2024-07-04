<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecordStatus extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function eventTypes(): HasMany
    {
        return $this->hasMany(EventType::class);
    }
}
