<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusCategory extends Model
{
    // A StatusCategory can be used by many Status records
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
}
