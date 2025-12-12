<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface TimelineServiceInterface
{
    public function handleStore(int $recruiterId, int $candidateId): Collection;

    public function handleShow(int $timeline_id): Collection;
}
