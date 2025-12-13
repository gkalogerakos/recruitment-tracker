<?php

namespace Services;

use App\Models\Step;
use App\Repositories\Interfaces\StepRepositoryInterface;
use App\Services\StepService;
use Mockery;
use Tests\TestCase;

class StepServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_handle_store_returns_collection_with_expected_keys()
    {

        $recruiter_id = 1;
        $timeline_id = 1;
        $step_category_id = 1;

        $stepModel = Mockery::mock(Step::class);
        $stepModel->shouldReceive('only')
            ->once()
            ->with(['id', 'recruiter_id', 'timeline_id'])
            ->andReturn(['id' => 1, 'timeline_id' => 1, 'recruiter_id' => 1]);

        $stepModel->shouldReceive('getAttribute')
            ->with('category')
            ->andReturn((object) ['name' => '1st Interview']);

        $repo = Mockery::mock(StepRepositoryInterface::class);
        $repo->shouldReceive('store')
            ->once()
            ->with($recruiter_id, $timeline_id, $step_category_id)
            ->andReturn($stepModel);

        $service = new StepService($repo);

        $result = $service->handleStore($recruiter_id, $timeline_id, $step_category_id);

        $this->assertEquals(['id' => 1, 'timeline_id' => 1, 'recruiter_id' => 1, 'step_category' => '1st Interview'], $result->toArray());
    }
}
