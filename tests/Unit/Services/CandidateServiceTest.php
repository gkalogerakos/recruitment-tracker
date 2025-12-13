<?php

namespace Services;

use App\Models\Candidate;
use App\Repositories\Interfaces\CandidateRepositoryInterface;
use App\Services\CandidateService;
use Mockery;
use Tests\TestCase;

class CandidateServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_handle_store_returns_collection_with_expected_keys()
    {
        $candidate_name = 'John';
        $candidate_surname = 'Doe';

        $candidateModel = Mockery::mock(Candidate::class);
        $candidateModel->shouldReceive('only')
            ->once()
            ->with(['id', 'name', 'surname'])
            ->andReturn(['id' => 1, 'name' => 'John', 'surname' => 'Doe']);

        $repo = Mockery::mock(CandidateRepositoryInterface::class);
        $repo->shouldReceive('store')
            ->once()
            ->with($candidate_name, $candidate_surname)
            ->andReturn($candidateModel);

        $service = new CandidateService($repo);

        $result = $service->handleStore($candidate_name, $candidate_surname);

        $this->assertEquals(['id' => 1, 'name' => 'John', 'surname' => 'Doe'], $result->toArray());
    }
}
