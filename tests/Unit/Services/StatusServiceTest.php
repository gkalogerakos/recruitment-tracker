<?php

namespace Services;

use App\Models\Status;
use App\Repositories\Interfaces\StatusRepositoryInterface;
use App\Services\StatusService;
use Mockery;
use Tests\TestCase;

class StatusServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_handle_store_returns_collection_with_expected_keys()
    {

        $recruiter_id = 1;
        $step_id = 1;
        $status_category_id = 1;

        $statusModel = Mockery::mock(Status::class);
        $statusModel->shouldReceive('only')
            ->once()
            ->with(['id', 'recruiter_id', 'step_id'])
            ->andReturn(['id' => 1, 'step_id' => 1, 'recruiter_id' => 1]);

        $statusModel->shouldReceive('getAttribute')
            ->with('category')
            ->andReturn((object) ['name' => 'Pending']);

        $repo = Mockery::mock(StatusRepositoryInterface::class);
        $repo->shouldReceive('store')
            ->once()
            ->with($recruiter_id, $step_id, $status_category_id)
            ->andReturn($statusModel);

        $service = new StatusService($repo);

        $result = $service->handleStore($recruiter_id, $step_id, $status_category_id);

        $this->assertEquals(['id' => 1, 'step_id' => 1, 'recruiter_id' => 1, 'status_category' => 'Pending'], $result->toArray());
    }
}
