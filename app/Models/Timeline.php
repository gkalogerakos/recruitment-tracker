<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $fillable = [
        'candidate_id',
        'recruiter_id',
    ];

    // The Candidate associated with this Timeline (One-to-One)
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // The Recruiter managing this Timeline
    public function manager()
    {
        return $this->belongsTo(Recruiter::class, 'recruiter_id');
    }

    // This Timeline has many Steps
    public function steps()
    {
        return $this->hasMany(Step::class);
    }
}
