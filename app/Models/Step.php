<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Step extends Model
{
    protected $fillable = [
        'recruiter_id',
        'timeline_id',
        'step_category_id',
    ];

    // Belongs to a Timeline
    public function timeline(): BelongsTo
    {
        return $this->belongsTo(Timeline::class);
    }

    // Belongs to a Step Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(StepCategory::class, 'step_category_id');
    }

    // Has many Status updates (the history)
    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class)->orderBy('created_at', 'asc');
    }

    // Created by a specific Recruiter
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Recruiter::class, 'recruiter_id');
    }
}
