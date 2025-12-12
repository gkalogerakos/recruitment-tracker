<?php

namespace App\Repositories;

use App\Models\Timeline;
use App\Repositories\Interfaces\TimelineRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentTimelineRepository implements TimelineRepositoryInterface
{
    private Timeline $model;

    public function __construct(Timeline $model)
    {
        $this->model = $model;
    }

    public function store(int $recruiterId, int $candidateId): Timeline
    {
        return $this->model->create([
            'recruiter_id' => $recruiterId,
            'candidate_id' => $candidateId,
        ]);
    }

    public function show(int $timelineId): Collection
    {
        $results = $this->model->query()->from('timelines', 'T')
            ->join('candidates as C', 'C.id', '=', 'T.candidate_id')

            ->join('recruiters as R', 'R.id', '=', 'T.recruiter_id')

            ->leftJoin('steps as Stp', 'Stp.timeline_id', '=', 'T.id')

            ->leftJoin('step_categories as StpC', 'StpC.id', '=', 'Stp.step_category_id')

            ->leftJoin('recruiters as R_creator', 'R_creator.id', '=', 'Stp.recruiter_id')

            ->leftJoin('statuses as Stt1', 'Stt1.step_id', '=', 'Stp.id')
            ->leftJoin('statuses as Stt2', function ($join) {
                $join->on('Stt2.step_id', '=', 'Stt1.step_id')
                    ->whereRaw('Stt2.created_at > Stt1.created_at');
            })

            ->leftJoin('status_categories as SttC', 'SttC.id', '=', 'Stt1.status_category_id')

            ->where('T.id', '=', $timelineId)

            ->whereNull('Stt2.id')

            ->select([
                'T.id AS timeline_id',
                'C.id AS candidate_id',
                'C.name AS candidate_name',
                'C.surname AS candidate_surname',
                'R.id AS recruiter_id',
                'R.name AS recruiter_name',

                'Stp.id AS step_id',
                'StpC.name AS step_category',
                'Stp.recruiter_id AS step_creator_id',
                'R_creator.name AS step_creator_name',
                'SttC.name AS current_status',
                'Stt1.created_at AS current_status_date',
            ])

            ->orderBy('Stp.created_at', 'ASC')
            ->get();

        return $results;
    }
}
