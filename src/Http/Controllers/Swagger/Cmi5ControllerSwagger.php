<?php

namespace EscolaLms\Cmi5\Http\Controllers\Swagger;

use EscolaLms\Cmi5\Http\Requests\Cmi5UploadRequest;
use Illuminate\Http\JsonResponse;

interface Cmi5ControllerSwagger
{
    public function upload(Cmi5UploadRequest $request): JsonResponse;
}
