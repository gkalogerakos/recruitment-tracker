<?php

namespace App\Repositories\Interfaces;

use App\Models\Timeline;
use Illuminate\Support\Collection;

interface TimelineRepositoryInterface
{
    public function store(int $recruiterId, int $candidateId): Timeline;

    public function show(int $timelineId): Collection;
}
