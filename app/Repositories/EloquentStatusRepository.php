<?php

namespace App\Repositories;

use App\Models\Status;
use App\Repositories\Interfaces\StatusRepositoryInterface;

class EloquentStatusRepository implements StatusRepositoryInterface
{
    private Status $model;

    public function __construct(Status $status)
    {
        $this->model = $status;
    }

    public function store(int $recruiter_id, int $step_id, int $status_category_id): Status
    {
        return $this->model->create([
            'recruiter_id' => $recruiter_id,
            'step_id' => $step_id,
            'status_category_id' => $status_category_id,
        ]);
    }
}
