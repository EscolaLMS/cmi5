<?php

namespace EscolaLms\Cmi5\Services;

use EscolaLms\Cmi5\Repositories\Contracts\Cmi5RepositoryContract;
use EscolaLms\Cmi5\Services\Contracts\Cmi5ServiceContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Cmi5Service implements Cmi5ServiceContract
{
    private Cmi5RepositoryContract $cmi5Repository;

    public function __construct(Cmi5RepositoryContract $cmi5Repository)
    {
        $this->cmi5Repository = $cmi5Repository;
    }

    public function getCmi5s(?int $perPage): LengthAwarePaginator
    {
        return $this->cmi5Repository->paginate($perPage ?? 15);
    }
}
