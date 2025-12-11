<?php

namespace App\Services\Interfaces;



use App\Models\Candidate;

interface CandidateServiceInterface
{
    public function handleStore(string $name, string $surname): Candidate;
}
