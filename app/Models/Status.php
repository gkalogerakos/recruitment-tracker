<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'recruiter_id',
        'step_id',
        'status_category_id',
    ];

    // Belongs to a Step
    public function step(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Step::class);
    }

    // Belongs to a Status Category
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StatusCategory::class, 'status_category_id');
    }

    // Created by a specific Recruiter
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Recruiter::class, 'recruiter_id');
    }
}
