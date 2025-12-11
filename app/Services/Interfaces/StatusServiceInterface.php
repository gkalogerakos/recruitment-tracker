<?php

namespace App\Services\Interfaces;



use App\Models\Status;


interface StatusServiceInterface
{
    public function handleStore(int $recruiter_id, int $step_id, int $status_category_id): Status;
}
