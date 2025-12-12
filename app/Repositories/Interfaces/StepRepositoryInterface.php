<?php

namespace App\Repositories\Interfaces;

use App\Models\Step;

interface StepRepositoryInterface
{
    public function store(int $recruiter_id, int $timeline_id, int $step_category_id): Step;
}
