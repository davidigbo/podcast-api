<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Podcast;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'podcast_id',
        'title',
        'audio_url',
        'duration',
        'release_date',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];
    
    public function podcast(): BelongsTo
    {
        return $this->belongsTo(Podcast::class);
    }
}
