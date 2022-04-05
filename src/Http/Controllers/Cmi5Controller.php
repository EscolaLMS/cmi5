<?php

namespace EscolaLms\Cmi5\Http\Controllers;

use EscolaLms\Cmi5\Http\Controllers\Swagger\Cmi5ControllerSwagger;
use EscolaLms\Cmi5\Http\Requests\Cmi5ListRequest;
use EscolaLms\Cmi5\Http\Requests\Cmi5UploadRequest;
use EscolaLms\Cmi5\Http\Resources\Cmi5Resource;
use EscolaLms\Cmi5\Services\Contracts\Cmi5ServiceContract;
use EscolaLms\Cmi5\Services\Contracts\Cmi5UploadServiceContract;
use EscolaLms\Core\Http\Controllers\EscolaLmsBaseController;
use Illuminate\Http\JsonResponse;

class Cmi5Controller extends EscolaLmsBaseController implements Cmi5ControllerSwagger
{
    private Cmi5ServiceContract $cmi5Service;
    private Cmi5UploadServiceContract $cmi5UploadService;

    public function __construct(Cmi5ServiceContract $cmi5Service, Cmi5UploadServiceContract $cmi5UploadService)
    {
        $this->cmi5Service = $cmi5Service;
        $this->cmi5UploadService = $cmi5UploadService;
    }

    public function upload(Cmi5UploadRequest $request): JsonResponse
    {
        $cmi5 = $this->cmi5UploadService->upload($request->file('file'));
        return $this->sendResponseForResource(Cmi5Resource::make($cmi5), __('Cmi5 uploaded successfully'));
    }

    public function list(Cmi5ListRequest $request): JsonResponse
    {
        $results = $this->cmi5Service->getCmi5s($request->get('per_page'));
        return $this->sendResponseForResource(Cmi5Resource::collection($results), __('Cmi5s retrieved successfully'));
    }
}
