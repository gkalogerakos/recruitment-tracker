<?php

namespace Controllers;

use App\Http\Controllers\Api\StepController;
use App\Http\Requests\StoreStepRequest;
use App\Services\Interfaces\StatusServiceInterface;
use App\Services\Interfaces\StepServiceInterface;
use Exception;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class StepControllerTest extends TestCase
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
            'step_category_id' => 1,
            'status_category_id' => 1,
        ];

        $request = Mockery::mock(StoreStepRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($requestData);

        $stepService = Mockery::mock(StepServiceInterface::class);
        $expectedStep = new Collection(['id' => 1, 'recruiter_id' => 1, 'timeline_id' => 1, 'step_category' => '1st Interview']);
        $stepService->shouldReceive('handleStore')
            ->once()
            ->with($requestData['recruiter_id'], $requestData['timeline_id'], $requestData['step_category_id'])
            ->andReturn($expectedStep);

        $statusService = Mockery::mock(StatusServiceInterface::class);
        $expectedStatus = new Collection(['id' => 1, 'recruiter_id' => 1, 'step_id' => 1, 'status_category' => 'Pending']);
        $statusService->shouldReceive('handleStore')
            ->once()
            ->with($requestData['recruiter_id'], $expectedStep['id'], $requestData['status_category_id'])
            ->andReturn($expectedStatus);

        $controller = new StepController($stepService, $statusService);

        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());

        $payload = json_decode($response->getContent(), true);
        $this->assertEquals('Step and Status created successfully.', $payload['message']);
        $this->assertEquals($expectedStep->toArray(), $payload['step']);
        $this->assertEquals($expectedStatus->toArray(), $payload['status']);
    }

    public function test_store_exception_returns_500()
    {
        $requestData = [
            'recruiter_id' => 1,
            'candidate_id' => 1,
            'timeline_id' => 1,
            'step_category_id' => 1,
            'status_category_id' => 1,
        ];

        $request = Mockery::mock(StoreStepRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($requestData);

        $stepService = Mockery::mock(StepServiceInterface::class);
        $stepService->shouldReceive('handleStore')
            ->once()
            ->with($requestData['recruiter_id'], $requestData['timeline_id'], $requestData['step_category_id'])
            ->andThrow(new Exception('test error'));

        $statusService = Mockery::mock(StatusServiceInterface::class);

        $controller = new StepController($stepService, $statusService);

        $response = $controller->store($request);

        $this->assertEquals(500, $response->getStatusCode());

        $payload = json_decode($response->getContent(), true);
        $this->assertEquals('Failed to create step.', $payload['message']);
        $this->assertEquals('test error', $payload['error']);
    }
}
