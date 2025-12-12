<?php

namespace App\Repositories;

use App\Models\Step;
use App\Repositories\Interfaces\StepRepositoryInterface;

class EloquentStepRepository implements StepRepositoryInterface
{
    private Step $model;

    public function __construct(Step $step)
    {
        $this->model = $step;
    }

    public function store(int $recruiter_id, int $timeline_id, int $step_category_id): Step
    {
        return $this->model->create([
            'recruiter_id' => $recruiter_id,
            'timeline_id' => $timeline_id,
            'step_category_id' => $step_category_id,
        ]);
    }
}
