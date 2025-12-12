<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStepRequest;
use App\Services\Interfaces\StatusServiceInterface;
use App\Services\Interfaces\StepServiceInterface;
use Illuminate\Http\JsonResponse;

class StepController extends Controller
{
    private StepServiceInterface $stepService;

    private StatusServiceInterface $statusService;

    public function __construct(StepServiceInterface $stepService, StatusServiceInterface $statusService)
    {
        $this->stepService = $stepService;
        $this->statusService = $statusService;
    }

    public function store(StoreStepRequest $request): JsonResponse
    {

        try {
            $requestData = $request->validated();

            $step = $this->stepService->handleStore(
                $requestData['recruiter_id'],
                $requestData['timeline_id'],
                $requestData['step_category_id']
            );

            $status = $this->statusService->handleStore(
                $requestData['recruiter_id'],
                $step->get('id'),
                $requestData['status_category_id'],
            );

            return response()->json([
                'message' => 'Step and Status created successfully.',
                'step' => $step,
                'status' => $status,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create step.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
