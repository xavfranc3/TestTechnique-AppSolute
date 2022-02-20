<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ExternalUserService;
use Exception;
use Illuminate\Http\JsonResponse;

class ExternalUserController extends Controller
{
    private ExternalUserService $externalUserService;

    public function __construct() {
        $this->externalUserService = new ExternalUserService();
    }

    /**
     * @OA\Get(
     *      path="/api/external_user",
     *      operationId="createExternalUser",
     *      tags={"Users"},
     *      summary="Create a user from external data",
     *      description="Create a user with data supplied from an external api",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *    )
     * )
     */
    public function storeExternalUser(): JsonResponse
    {

        $result['status'] = 200;
        try {
            $result['data'] = $this->externalUserService->createExternalUser();
        } catch (Exception $error) {
            $result = ['status' => 500, 'error' => $error->getMessage()];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * @OA\Get(
     *      path="/api/external_user/laravelHelper",
     *      operationId="createExternalUserWithLaravelHelper",
     *      tags={"Users"},
     *      summary="Create a user from external data using Laravel Helper",
     *      description="Create a user with data supplied from an external api by using built-in laravel helpers",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *    )
     * )
     */
    public function storeExternalUserWithLaravelHelper(): JsonResponse
    {

        $result['status'] = 200;
        try {
            $result['data'] = $this->externalUserService->createNewUserWithLaravelHelper();
        } catch (Exception $error) {
            $result = ['status' => 500, 'error' => $error->getMessage()];
        }
        return response()->json($result, $result['status']);
    }
}
