<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $fillable = [
        'recruiter_id',
        'timeline_id',
        'step_category_id',
    ];
    // Belongs to a Timeline
    public function timeline(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Timeline::class);
    }

    // Belongs to a Step Category
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StepCategory::class, 'step_category_id');
    }

    // Has many Status updates (the history)
    public function statuses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Status::class)->orderBy('created_at', 'asc');
    }

    // Created by a specific Recruiter
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Recruiter::class, 'recruiter_id');
    }

    // This defines a relationship that fetches only the LATEST status
    public function currentStatus(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        // One-to-One relationship that orders by creation time descending (latest first)
        // and only limits the result to 1.
        return $this->hasOne(Status::class)->latest();
    }
}
