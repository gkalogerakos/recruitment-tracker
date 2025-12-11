<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // Belongs to a Step
    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    // Belongs to a Status Category
    public function category()
    {
        return $this->belongsTo(StatusCategory::class, 'status_category_id');
    }

    // Created by a specific Recruiter
    public function creator()
    {
        return $this->belongsTo(Recruiter::class, 'recruiter_id');
    }
}
