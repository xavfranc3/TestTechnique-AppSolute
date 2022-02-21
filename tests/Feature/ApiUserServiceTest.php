<?php

namespace Tests\Feature;

use App\Services\ApiUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiUserServiceTest extends TestCase
{
    use RefreshDatabase;

    private ApiUserService $apiUserService;

    public function setUp(): void
    {
        parent::setUp();
        parent::initDatabase();
        $this->apiUserService = new ApiUserService();
    }

    public function tearDown(): void
    {
        parent::resetDatabase();
        parent::tearDown();
    }

    public function test_createApiUserService_stores_api_user_in_db(): void {
        $apiUser = ['user_name' => 'hello', 'password' => 'hello'];
        $createdUser = $this->apiUserService->createApiUser($apiUser);
        $this->assertEquals($apiUser['user_name'], $createdUser->getAttributeValue('user_name'));
    }

    public function test_authenticateApiUser_authenticates_user(): void {
        $apiUser = ['user_name' => 'admin', 'password' => 'admin'];
        $createdUser = $this->apiUserService->createApiUser($apiUser);
        $this->assertTrue(Hash::check($apiUser['password'], $createdUser->getAttributeValue('password')));
    }
}
