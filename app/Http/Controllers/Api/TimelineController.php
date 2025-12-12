<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimelineRequest;
use App\Services\Interfaces\CandidateServiceInterface;
use App\Services\Interfaces\TimelineServiceInterface;
use Illuminate\Http\JsonResponse;

class TimelineController extends Controller
{
    private TimelineServiceInterface $timelineService;

    private CandidateServiceInterface $candidateService;

    public function __construct(TimelineServiceInterface $timelineService, CandidateServiceInterface $candidateService)
    {
        $this->timelineService = $timelineService;
        $this->candidateService = $candidateService;
    }

    public function store(StoreTimelineRequest $request): JsonResponse
    {
        try {
            $requestData = $request->validated();

            $newCandidate = $this->candidateService->handleStore($requestData['candidate_name'], $requestData['candidate_surname']);

            $timeline = $this->timelineService->handleStore($requestData['recruiter_id'], $newCandidate->get('id'));

            return response()->json([
                'message' => 'Timeline and Candidate created successfully.',
                'timeline' => $timeline,
                'candidate' => $newCandidate,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create timeline.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $timeline_id): JsonResponse
    {
        try {
            $timeline = $this->timelineService->handleShow($timeline_id);

            if ($timeline->isEmpty()) {
                return response()->json([
                    'message' => 'Failed to retrieve timeline.',
                    'error' => 'Timeline not found.',
                ], 404);
            }

            return response()->json([
                'message' => 'Timeline retrieved successfully.',
                'timeline' => $timeline,
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to retrieve timeline.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
