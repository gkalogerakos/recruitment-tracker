<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface CandidateServiceInterface
{
    public function handleStore(string $name, string $surname): Collection;
}
