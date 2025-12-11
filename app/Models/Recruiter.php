<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Recruiter extends Model
{
    // A Recruiter can manage many Timelines
    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }

    // A Recruiter can create many Steps
    public function createdSteps()
    {
        return $this->hasMany(Step::class, 'created_by_recruiter_id');
    }

    // A Recruiter can create many Status updates
    public function createdStatuses()
    {
        return $this->hasMany(Status::class, 'created_by_recruiter_id');
    }
}
