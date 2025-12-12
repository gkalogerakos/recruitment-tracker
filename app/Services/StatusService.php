<?php

namespace App\Services;

use App\Repositories\Interfaces\StatusRepositoryInterface;
use App\Services\Interfaces\StatusServiceInterface;
use Illuminate\Support\Collection;

class StatusService implements StatusServiceInterface
{
    private StatusRepositoryInterface $statusRepository;

    public function __construct(StatusRepositoryInterface $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function handleStore(int $recruiter_id, int $step_id, int $status_category_id): Collection
    {
        $status = $this->statusRepository->store($recruiter_id, $step_id, $status_category_id);

        return collect($status->only(['id', 'recruiter_id', 'step_id']))->put('status_category', $status->category->name);
    }
}
