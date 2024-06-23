<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_profile_id',
        'document_type_id',
        'name',
        'description',
        'documentPath',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class);
    }

    public function docType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }
}
