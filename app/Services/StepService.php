<?php

namespace App\Services;

use App\Repositories\Interfaces\StepRepositoryInterface;
use App\Services\Interfaces\StepServiceInterface;
use Illuminate\Support\Collection;

class StepService implements StepServiceInterface
{
    private StepRepositoryInterface $stepRepository;

    public function __construct(StepRepositoryInterface $stepRepository)
    {
        $this->stepRepository = $stepRepository;
    }

    public function handleStore(int $recruiter_id, int $timeline_id, int $step_category_id): Collection
    {
        $step = $this->stepRepository->store($recruiter_id, $timeline_id, $step_category_id);

        return collect($step->only(['id', 'recruiter_id', 'timeline_id']))->put('step_category', $step->category->name);
    }
}
