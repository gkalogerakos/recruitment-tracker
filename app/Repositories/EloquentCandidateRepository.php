<?php

namespace App\Repositories;

use App\Models\Candidate;
use App\Repositories\Interfaces\CandidateRepositoryInterface;

class EloquentCandidateRepository implements CandidateRepositoryInterface
{
    private Candidate $model;

    public function __construct(Candidate $model)
    {
        $this->model = $model;
    }

    public function store(string $name, string $surname): Candidate
    {
        return $this->model->create([
            'name' => $name,
            'surname' => $surname,
        ]);
    }
}
