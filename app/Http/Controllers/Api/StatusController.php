<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\StoreStatusRequest;
use App\Services\Interfaces\StatusServiceInterface;

class StatusController
{
    private StatusServiceInterface $statusService;
    public function __construct(StatusServiceInterface $statusService)
    {
        $this->statusService = $statusService;
    }

    public function store(StoreStatusRequest $request)
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
                'status' => $status->only(['id', 'recruiter_id', 'step_id']) + ['status_category' => $status->category->name],
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to create status.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
