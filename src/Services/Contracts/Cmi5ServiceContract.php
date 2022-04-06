<?php

namespace EscolaLms\Cmi5\Services\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface Cmi5ServiceContract
{
    public function getCmi5s(?int $perPage): LengthAwarePaginator;

    public function getPlayerData(int $cmi5AuId, string $token, ?int $courseId = null, ?int $topicId = null): array;
}
