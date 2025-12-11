<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimelineRequest;
use App\Services\Interfaces\CandidateServiceInterface;
use App\Services\Interfaces\TimelineServiceInterface;

class TimelineController extends Controller
{

    private TimelineServiceInterface $timelineService;
    private CandidateServiceInterface $candidateService;

    public function __construct(TimelineServiceInterface $timelineService, CandidateServiceInterface $candidateService)
    {
        $this->timelineService = $timelineService;
        $this->candidateService = $candidateService;
    }
    public function store(StoreTimelineRequest $request)
    {
        try {
            $requestData = $request->validated();

            $newCandidate = $this->candidateService->handleStore($requestData['candidate_name'], $requestData['candidate_surname']);

            $timeline = $this->timelineService->handleStore($requestData['recruiter_id'], $newCandidate->id);

            return response()->json([
                'message' => 'Timeline and Candidate created successfully.',
                'timeline' => $timeline->only(['id', 'recruiter_id', 'candidate_id']),
                'candidate' => $newCandidate->only(['id', 'name', 'surname']),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create timeline.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
