<?php

namespace EscolaLms\Cmi5\Services\Contracts;

use EscolaLms\Cmi5\Models\Cmi5;
use Illuminate\Http\UploadedFile;

interface Cmi5ServiceContract
{
    public function upload(UploadedFile $file): Cmi5;
}
