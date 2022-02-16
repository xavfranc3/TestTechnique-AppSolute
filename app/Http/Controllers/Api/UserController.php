<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AstrologicalSignsService;
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
    public function index(): Response
    {
        $users = $this->userService->paginateUsers();
        return response(['users' => $users]);
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
    public function show($id): Response
    {
        $user = $this->userService->getUser($id);
        $chineseSign = $this->astrologyService->getChineseSign($user['date_of_birth']);
        $zodiacSign = $this->astrologyService->getZodiacSign($user['date_of_birth']);
        return response(['userDetails' => $user, 'chineseSign' => $chineseSign, 'zodiacSign' => $zodiacSign]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return response('usercontroller store');
    }

}
