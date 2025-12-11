<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepCategory extends Model
{
    // A StepCategory can be used by many Steps
    public function steps()
    {
        return $this->hasMany(Step::class);
    }
}
