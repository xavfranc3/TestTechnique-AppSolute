<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AstrologicalSignsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;

class UserController extends Controller
{

    private UserService $userService;
    private AstrologicalSignsService $astrologyService;

    public function __construct(UserService $userService, AstrologicalSignsService $astrologyService) {
        $this->userService = new UserService();
        $this->astrologyService = new AstrologicalSignsService();
    }
    /**
     * @OA\Get(
     *      path="/api/users",
     *      operationId="getUsersList",
     *      tags={"Users"},
     *      summary="Get list of users",
     *      description="Get list of users with a default pagination of 5",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *    )
     * )
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->paginateUsers();
        return response()->json($users);
    }

    /**
     * @OA\Get(
     *      path="/api/users/{id}",
     *      operationId="getUser",
     *      tags={"Users"},
     *      summary="Get user information",
     *      description="Get user details and Zodiac and Chinese astrological signs",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *    )
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $user = $this->userService->getUser($id);
            $chineseSign = $this->astrologyService->getChineseSign($user['date_of_birth']);
            $zodiacSign = $this->astrologyService->getZodiacSign($user['date_of_birth']);

            $result = ['data' => ['userDetails' => $user, 'chineseSign' => $chineseSign, 'zodiacSign' => $zodiacSign]];
        } catch(Exception $error) {
            $result = [
                'status' => 500,
                'error' => $error->getMessage()
            ];
        }
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->userService->createUser($request);
        } catch (Exception $error) {
            $result = [
                'status' => 500,
                'error' => $error->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

}
