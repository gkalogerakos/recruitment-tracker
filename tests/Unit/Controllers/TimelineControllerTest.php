<?php

namespace Controllers;

use App\Http\Controllers\Api\TimelineController;
use App\Http\Requests\StoreTimelineRequest;
use App\Services\Interfaces\CandidateServiceInterface;
use App\Services\Interfaces\TimelineServiceInterface;
use Exception;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class TimelineControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_store_success_returns_201_and_payload()
    {
        $requestData = [
            'candidate_name' => 'John',
            'candidate_surname' => 'Doe',
            'recruiter_id' => 1,
        ];

        $request = Mockery::mock(StoreTimelineRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($requestData);

        $candidateService = Mockery::mock(CandidateServiceInterface::class);
        $expectedCandidate = new Collection(['id' => 1, 'name' => 'John', 'surname' => 'Doe']);
        $candidateService->shouldReceive('handleStore')
            ->once()
            ->with($requestData['candidate_name'], $requestData['candidate_surname'])
            ->andReturn($expectedCandidate);

        $timelineService = Mockery::mock(TimelineServiceInterface::class);
        $expectedTimeline = new Collection(['id' => 1, 'recruiter_id' => 1, 'candidate_id' => 1]);
        $timelineService->shouldReceive('handleStore')
            ->once()
            ->with($requestData['recruiter_id'], $expectedCandidate['id'])
            ->andReturn($expectedTimeline);

        $controller = new TimelineController($timelineService, $candidateService);

        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());

        $payload = json_decode($response->getContent(), true);
        $this->assertEquals('Timeline and Candidate created successfully.', $payload['message']);
        $this->assertEquals($expectedTimeline->toArray(), $payload['timeline']);
        $this->assertEquals($expectedCandidate->toArray(), $payload['candidate']);
    }

    public function test_store_exception_returns_500()
    {
        $requestData = [
            'candidate_name' => 'John',
            'candidate_surname' => 'Doe',
            'recruiter_id' => 1,
        ];

        $request = Mockery::mock(StoreTimelineRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($requestData);

        $candidateService = Mockery::mock(CandidateServiceInterface::class);
        $candidateService->shouldReceive('handleStore')
            ->once()
            ->andThrow(new Exception('test error'));

        $timelineService = Mockery::mock(TimelineServiceInterface::class);

        $controller = new TimelineController($timelineService, $candidateService);

        $response = $controller->store($request);

        $this->assertEquals(500, $response->getStatusCode());

        $payload = json_decode($response->getContent(), true);
        $this->assertStringContainsString('Failed to create timeline.', $payload['message']);
        $this->assertStringContainsString('test error', $payload['error']);
    }

    public function test_show_success_returns_200_and_timeline()
    {
        $timelineId = 1;

        $candidateService = Mockery::mock(CandidateServiceInterface::class);
        $timelineService = Mockery::mock(TimelineServiceInterface::class);

        $returnedTimeline = new Collection([['id' => $timelineId, 'note' => 'ok']]);
        $timelineService->shouldReceive('handleShow')
            ->once()
            ->with($timelineId)
            ->andReturn($returnedTimeline);

        $controller = new TimelineController($timelineService, $candidateService);

        $response = $controller->show($timelineId);

        $this->assertEquals(200, $response->getStatusCode());

        $payload = json_decode($response->getContent(), true);
        $this->assertEquals('Timeline retrieved successfully.', $payload['message']);
        $this->assertEquals($returnedTimeline->toArray(), $payload['timeline']);
    }

    public function test_show_not_found_returns_404()
    {
        $timelineId = 42;

        $candidateService = Mockery::mock(CandidateServiceInterface::class);
        $timelineService = Mockery::mock(TimelineServiceInterface::class);

        $timelineService->shouldReceive('handleShow')
            ->once()
            ->with($timelineId)
            ->andReturn(new Collection);

        $controller = new TimelineController($timelineService, $candidateService);

        $response = $controller->show($timelineId);

        $this->assertEquals(404, $response->getStatusCode());

        $payload = json_decode($response->getContent(), true);
        $this->assertEquals('Failed to retrieve timeline.', $payload['message']);
        $this->assertEquals('Timeline not found.', $payload['error']);
    }

    public function test_show_exception_returns_500()
    {
        $timelineId = 7;

        $candidateService = Mockery::mock(CandidateServiceInterface::class);
        $timelineService = Mockery::mock(TimelineServiceInterface::class);

        $timelineService->shouldReceive('handleShow')
            ->once()
            ->with($timelineId)
            ->andThrow(new Exception('test error'));

        $controller = new TimelineController($timelineService, $candidateService);

        $response = $controller->show($timelineId);

        $this->assertEquals(500, $response->getStatusCode());

        $payload = json_decode($response->getContent(), true);
        $this->assertStringContainsString('Failed to retrieve timeline.', $payload['message']);
        $this->assertStringContainsString('test error', $payload['error']);
    }
}
