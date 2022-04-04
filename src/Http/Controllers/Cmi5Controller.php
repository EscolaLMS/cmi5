<?php

namespace EscolaLms\Cmi5\Http\Controllers;

use EscolaLms\Cmi5\Http\Controllers\Swagger\Cmi5ControllerSwagger;
use EscolaLms\Cmi5\Http\Requests\Cmi5UploadRequest;
use EscolaLms\Cmi5\Services\Contracts\Cmi5ServiceContract;
use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use Illuminate\Http\JsonResponse;

class Cmi5Controller extends EscolaLmsBaseController implements Cmi5ControllerSwagger
{
    private Cmi5ServiceContract $cmi5Service;

    public function __construct(Cmi5ServiceContract $cmi5Service)
    {
        $this->cmi5Service = $cmi5Service;
    }

    public function upload(Cmi5UploadRequest $request): JsonResponse
    {
        $this->cmi5Service->upload($request->file('file'));
        return $this->sendSuccess('Cmi5 uploaded successfully');
    }
}
