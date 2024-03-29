<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="UserApi OpenApi Documentation",
 *      description="L5 Swagger OpenApi",
 *      @OA\Contact(
 *          email="dev.xavier.francois@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API Server"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Get (
     *     path="/",
     *     summary="Welcome page",
     *     description="Hello",
     *     operationId="Welcome",
     *     tags={"Welcome"},
     * @OA\Response (
            response="200",
     *     description="Successful",
     *     )
     * )
     */
    public function welcome(): JsonResponse
    {
        return response()->json('Hello');
    }
}
