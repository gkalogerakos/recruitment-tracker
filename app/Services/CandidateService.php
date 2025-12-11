<?php

namespace App\Services;




use App\Models\Candidate;
use App\Services\Interfaces\CandidateServiceInterface;

class CandidateService implements CandidateServiceInterface
{
    public function handleStore(string $name, string $surname): Candidate
    {
        return Candidate::create([
            'name' => $name,
            'surname' => $surname,
        ]);

    }
}
