<?php

namespace App\Services;



use App\Models\Step;

use App\Services\Interfaces\StepServiceInterface;


class StepService implements StepServiceInterface
{
    public function handleStore(int $recruiter_id, int $timeline_id, int $step_category_id): Step

    {
        return Step::create([
            'recruiter_id' => $recruiter_id,
            'timeline_id' => $timeline_id,
            'step_category_id' => $step_category_id,
        ]);
    }
}
