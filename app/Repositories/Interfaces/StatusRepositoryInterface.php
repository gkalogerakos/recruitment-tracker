<?php

namespace App\Repositories\Interfaces;

use App\Models\Status;

interface StatusRepositoryInterface
{
    public function store(int $recruiter_id, int $step_id, int $status_category_id): Status;
}
