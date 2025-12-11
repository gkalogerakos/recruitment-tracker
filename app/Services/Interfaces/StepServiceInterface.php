<?php

namespace App\Services\Interfaces;



use App\Models\Step;


interface StepServiceInterface
{
    public function handleStore(int $recruiter_id, int $timeline_id, int $step_category_id): Step;
}
