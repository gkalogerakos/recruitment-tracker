<?php

namespace App\Repositories\Interfaces;

use App\Models\Candidate;

interface CandidateRepositoryInterface
{
    public function store(string $name, string $surname): Candidate;
}
