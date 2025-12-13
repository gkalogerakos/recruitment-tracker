<?php

namespace Controllers;

use App\Http\Controllers\Api\StatusController;
use App\Http\Requests\StoreStatusRequest;
use App\Services\Interfaces\StatusServiceInterface;
use Exception;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class StatusControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_store_success_returns_201_and_payload()
    {
        $requestData = [
            'recruiter_id' => 1,
            'candidate_id' => 1,
            'timeline_id' => 1,
            'step_id' => 1,
            'status_category_id' => 1,
        ];

        $request = Mockery::mock(StoreStatusRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($requestData);

        $statusService = Mockery::mock(StatusServiceInterface::class);
        $expectedStatus = new Collection(['id' => 1, 'recruiter_id' => 1, 'step_id' => 1, 'status_category' => 'Completed']);
        $statusService->shouldReceive('handleStore')
            ->once()
            ->with($requestData['recruiter_id'], $requestData['step_id'], $requestData['status_category_id'])
            ->andReturn($expectedStatus);

        $controller = new StatusController($statusService);

        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());

        $payload = json_decode($response->getContent(), true);
        $this->assertEquals('Status created successfully.', $payload['message']);
        $this->assertEquals($expectedStatus->toArray(), $payload['status']);
    }

    public function test_store_exception_returns_500()
    {
        $requestData = [
            'recruiter_id' => 1,
            'step_id' => 1,
            'status_category_id' => 1,
        ];

        $request = Mockery::mock(StoreStatusRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($requestData);

        $statusService = Mockery::mock(StatusServiceInterface::class);
        $statusService->shouldReceive('handleStore')
            ->once()
            ->with($requestData['recruiter_id'], $requestData['step_id'], $requestData['status_category_id'])
            ->andThrow(new Exception('test error'));

        $controller = new StatusController($statusService);

        $response = $controller->store($request);

        $this->assertEquals(500, $response->getStatusCode());

        $payload = json_decode($response->getContent(), true);
        $this->assertEquals('Failed to create status.', $payload['message']);
        $this->assertEquals('test error', $payload['error']);
    }
}
