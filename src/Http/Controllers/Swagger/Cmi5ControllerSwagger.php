<?php

namespace EscolaLms\Cmi5\Http\Controllers\Swagger;

use EscolaLms\Cmi5\Http\Requests\Cmi5ListRequest;
use EscolaLms\Cmi5\Http\Requests\Cmi5UploadRequest;
use Illuminate\Http\JsonResponse;

interface Cmi5ControllerSwagger
{
    /**
     * @OA\Post(
     *     path="/api/admin/cmi5",
     *     summary="Convert ZIP Cmi5 Package into Escola LMS Cmi5 storage",
     *     tags={"cmi5"},
     *     security={
     *         {"passport": {}},
     *     },
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="file",
     *                      type="string",
     *                      format="binary"
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Cmi5 data",
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Endpoint requires authentication",
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="User doesn't have required access rights",
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Server-side error",
     *      ),
     * )
     *
     * @param Cmi5UploadRequest $request
     * @return JsonResponse
     */
    public function upload(Cmi5UploadRequest $request): JsonResponse;

    /**
     * @OA\Get(
     *     path="/api/admin/cmi5/",
     *     summary="Get a listing of the cmi5",
     *     tags={"cmi5"},
     *     security={
     *         {"passport": {}},
     *     },
     *     @OA\Parameter(
     *         description="page",
     *         in="query",
     *         name="page",
     *         @OA\Schema(
     *             type="number"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="per_page",
     *         in="query",
     *         name="per_page",
     *         @OA\Schema(
     *             type="number"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of available cmi5s",
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Endpoint requires authentication",
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="User doesn't have required access rights",
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Server-side error",
     *      ),
     * )
     *
     * @param Cmi5ListRequest $request
     * @return JsonResponse
     */
    public function list(Cmi5ListRequest $request): JsonResponse;
}
