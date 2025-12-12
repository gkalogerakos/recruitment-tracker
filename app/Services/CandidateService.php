<?php

namespace App\Services;

use App\Repositories\Interfaces\CandidateRepositoryInterface;
use App\Services\Interfaces\CandidateServiceInterface;
use Illuminate\Support\Collection;

class CandidateService implements CandidateServiceInterface
{
    private CandidateRepositoryInterface $candidateRepository;

    public function __construct(CandidateRepositoryInterface $candidateRepository)
    {
        $this->candidateRepository = $candidateRepository;
    }

    public function handleStore(string $name, string $surname): Collection
    {
        $candidate = $this->candidateRepository->store($name, $surname);

        return collect($candidate->only(['id', 'name', 'surname']));

    }
}
