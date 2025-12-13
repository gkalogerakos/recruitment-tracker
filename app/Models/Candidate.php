<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'name',
        'surname',
    ];

    // A Candidate has one Timeline
    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }
}
