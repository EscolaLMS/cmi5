<?php

namespace EscolaLms\Cmi5\Policies;

use EscolaLms\Cmi5\Enums\Cmi5PermissionEnum;
use EscolaLms\Core\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Cmi5Policy
{
    use HandlesAuthorization;

    public function upload(User $user): bool
    {
        return $user->can(Cmi5PermissionEnum::CMI5_UPLOAD);
    }
}
