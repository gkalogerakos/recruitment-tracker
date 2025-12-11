<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    // Belongs to a Timeline
    public function timeline()
    {
        return $this->belongsTo(Timeline::class);
    }

    // Belongs to a Step Category
    public function category()
    {
        return $this->belongsTo(StepCategory::class, 'step_category_id');
    }

    // Has many Status updates (the history)
    public function statuses()
    {
        return $this->hasMany(Status::class)->orderBy('created_at', 'asc');
    }

    // Created by a specific Recruiter
    public function creator()
    {
        return $this->belongsTo(Recruiter::class, 'recruiter_id');
    }

    // This defines a relationship that fetches only the LATEST status
    public function currentStatus()
    {
        // One-to-One relationship that orders by creation time descending (latest first)
        // and only limits the result to 1.
        return $this->hasOne(Status::class)->latest();
    }
}
