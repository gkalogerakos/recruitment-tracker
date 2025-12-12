<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface StepServiceInterface
{
    public function handleStore(int $recruiter_id, int $timeline_id, int $step_category_id): Collection;
}
