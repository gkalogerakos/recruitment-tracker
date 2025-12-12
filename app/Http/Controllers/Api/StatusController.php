<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreStatusRequest;
use App\Services\Interfaces\StatusServiceInterface;
use Illuminate\Http\JsonResponse;

class StatusController
{
    private StatusServiceInterface $statusService;

    public function __construct(StatusServiceInterface $statusService)
    {
        $this->statusService = $statusService;
    }

    public function store(StoreStatusRequest $request): JsonResponse
    {
        try {
            $requestData = $request->validated();

            $status = $this->statusService->handleStore(
                $requestData['recruiter_id'],
                $requestData['step_id'],
                $requestData['status_category_id'],
            );

            return response()->json([
                'message' => 'Status created successfully.',
                'status' => $status,
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to create status.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
