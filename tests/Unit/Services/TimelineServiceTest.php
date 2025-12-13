<?php

namespace Tests\Unit\Services;

use App\Models\Timeline;
use App\Repositories\Interfaces\TimelineRepositoryInterface;
use App\Services\TimelineService;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class TimelineServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_handle_store_returns_collection_with_expected_keys()
    {
        $recruiterId = 1;
        $candidateId = 1;

        $timelineModel = Mockery::mock(Timeline::class);
        $timelineModel->shouldReceive('only')
            ->once()
            ->with(['id', 'recruiter_id', 'candidate_id'])
            ->andReturn(['id' => 1, 'recruiter_id' => 1, 'candidate_id' => 1]);

        $repo = Mockery::mock(TimelineRepositoryInterface::class);
        $repo->shouldReceive('store')
            ->once()
            ->with($recruiterId, $candidateId)
            ->andReturn($timelineModel);

        $service = new TimelineService($repo);

        $result = $service->handleStore($recruiterId, $candidateId);

        $this->assertEquals(['id' => 1, 'recruiter_id' => 1, 'candidate_id' => 1], $result->toArray());
    }

    public function test_handle_show_returns_empty_collection_when_no_results()
    {
        $timelineId = 1;

        $repo = Mockery::mock(TimelineRepositoryInterface::class);
        $repo->shouldReceive('show')
            ->once()
            ->with($timelineId)
            ->andReturn(new Collection);

        $service = new TimelineService($repo);

        $result = $service->handleShow($timelineId);

        $this->assertTrue($result->isEmpty());
    }

    public function test_handle_show_returns_timeline_info_with_empty_steps_when_no_steps()
    {
        $timelineId = 1;

        $timelineData = new class
        {
            public $step_id = null;

            public function only($keys)
            {
                return [
                    'timeline_id' => 1,
                    'candidate_id' => 1,
                    'candidate_name' => 'John',
                    'candidate_surname' => 'Doe',
                    'recruiter_id' => 1,
                    'recruiter_name' => 'Recruiter A',
                ];
            }
        };

        $repo = Mockery::mock(TimelineRepositoryInterface::class);
        $repo->shouldReceive('show')
            ->once()
            ->with($timelineId)
            ->andReturn($results = new Collection([$timelineData]));

        $service = new TimelineService($repo);

        $result = $service->handleShow($timelineId);

        $this->assertEquals(1, $result->get('id'));
        $this->assertEquals(1, $result->get('candidate_id'));
        $this->assertEquals('John', $result->get('candidate_name'));
        $this->assertEquals([], $result->get('steps'));
    }

    public function test_handle_show_returns_timeline_with_steps_when_steps_present()
    {
        $timelineId = 1;

        $row1 = new class
        {
            public $step_id = 1;

            public $step_category = '1st Interview';

            public $step_creator_id = 1;

            public $step_creator_name = 'Recruiter A';

            public $current_status = 'Completed';

            public $current_status_date = '2025-01-01';

            public function only($keys)
            {
                return [
                    'timeline_id' => 1,
                    'candidate_id' => 1,
                    'candidate_name' => 'John',
                    'candidate_surname' => 'Doe',
                    'recruiter_id' => 1,
                    'recruiter_name' => 'Recruiter A',
                ];
            }
        };

        $row2 = new class
        {
            public $step_id = 2;

            public $step_category = 'Tech Assessment';

            public $step_creator_id = 1;

            public $step_creator_name = 'Recruiter A';

            public $current_status = 'Pending';

            public $current_status_date = '2025-02-02';

            public function only($keys)
            {
                return [
                    'timeline_id' => 1,
                    'candidate_id' => 1,
                    'candidate_name' => 'John',
                    'candidate_surname' => 'Doe',
                    'recruiter_id' => 1,
                    'recruiter_name' => 'Recruiter A',
                ];
            }
        };

        $results = new Collection([$row1, $row2]);

        $repo = Mockery::mock(TimelineRepositoryInterface::class);
        $repo->shouldReceive('show')
            ->once()
            ->with($timelineId)
            ->andReturn($results);

        $service = new TimelineService($repo);

        $result = $service->handleShow($timelineId);

        $this->assertEquals(1, $result->get('id'));
        $this->assertInstanceOf(Collection::class, $result->get('steps'));
        $this->assertCount(2, $result->get('steps'));
        $stepsArray = $result->get('steps')->toArray();
        $this->assertEquals(1, $stepsArray[0]['step_id']);
        $this->assertEquals('Completed', $stepsArray[0]['current_status']);
        $this->assertEquals('1st Interview', $stepsArray[0]['step_category']);
        $this->assertEquals(2, $stepsArray[1]['step_id']);
        $this->assertEquals('Pending', $stepsArray[1]['current_status']);
        $this->assertEquals('Tech Assessment', $stepsArray[1]['step_category']);
    }
}
