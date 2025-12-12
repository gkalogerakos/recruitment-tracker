<?php

namespace App\Services;

use App\Repositories\Interfaces\TimelineRepositoryInterface;
use App\Services\Interfaces\TimelineServiceInterface;
use Illuminate\Support\Collection;

class TimelineService implements TimelineServiceInterface
{
    private TimelineRepositoryInterface $timelineRepository;

    public function __construct(TimelineRepositoryInterface $timelineRepository)
    {
        $this->timelineRepository = $timelineRepository;
    }

    public function handleStore(int $recruiterId, int $candidateId): Collection
    {
        $timeline = $this->timelineRepository->store($recruiterId, $candidateId);

        return collect($timeline->only(['id', 'recruiter_id', 'candidate_id']));
    }

    public function handleShow(int $timeline_id): Collection
    {
        $results = $this->timelineRepository->show($timeline_id);

        if ($results->isEmpty()) {
            return $results;
        }

        $timelineInfo = collect($results->first()->only([
            'timeline_id',
            'candidate_id',
            'candidate_name',
            'candidate_surname',
            'recruiter_id',
            'recruiter_name',
        ]))->put('steps', [])->map(function ($value, $key) {
            if ($key === 'timeline_id') {
                return ['id' => $value];
            }

            return [$key => $value];
        })->collapse();

        if ($results->first()->step_id === null) {
            // No steps associated with this timeline
            return collect($timelineInfo);
        }

        $timelineInfo['steps'] = $results->map(function ($row) {
            return [
                'step_id' => $row->step_id,
                'step_category' => $row->step_category,
                'step_creator_id' => $row->step_creator_id,
                'step_creator_name' => $row->step_creator_name,
                'current_status' => $row->current_status,
                'current_status_date' => $row->current_status_date,
            ];
        });

        return collect($timelineInfo);
    }
}
