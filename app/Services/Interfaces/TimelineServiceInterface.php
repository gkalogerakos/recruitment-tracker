<?php

namespace App\Services\Interfaces;



use App\Models\Timeline;

interface TimelineServiceInterface
{
    public function handleStore(int $recruiterId, int $candidateId): Timeline;
}
