<?php

namespace App\Services;



use App\Models\Status;

use App\Services\Interfaces\StatusServiceInterface;


class StatusService implements StatusServiceInterface
{
    public function handleStore(int $recruiter_id, int $step_id, int $status_category_id): Status

    {
        return Status::create([
            'recruiter_id' => $recruiter_id,
            'step_id' => $step_id,
            'status_category_id' => $status_category_id,
        ]);
    }
}
