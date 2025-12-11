<?php

namespace App\Services;



use App\Models\Timeline;
use App\Services\Interfaces\TimelineServiceInterface;

class TimelineService implements TimelineServiceInterface
{
    public function handleStore(int $recruiterId, int $candidateId): Timeline

    {
        return Timeline::create([
            'recruiter_id' => $recruiterId,
            'candidate_id' => $candidateId,
        ]);
    }
}
