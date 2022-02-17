<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use App\Utils\AppConstants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{

    use RefreshDatabase;

    protected array $newUser;
    private UserService $userService;

    public function setUp():void {
        parent::setUp();
        $this->initDatabase();
        $this->userService = new UserService();
        $this->newUser = AppConstants::NEW_USER;
    }

    public function tearDown(): void
    {
        $this->resetDatabase();
        parent::tearDown();
    }

    public function test_paginate_users_should_return_0(): void {
        $users = $this->userService->paginateUsers();
        $this->assertCount(0, $users);
    }
    public function test_paginate_users_should_return_5(): void {
        User::factory()->count(7)->create();
        $users = $this->userService->paginateUsers();
        $this->assertCount(5, $users);
    }
    public function test_paginate_users_should_return_3(): void {
        User::factory()->count(3)->create();
        $users = $this->userService->paginateUsers();
        $this->assertCount(3, $users);
    }

    public function test_getUser_returns_manually_seeded_user(): void {
        User::factory()->count(5)->create();

//        Manually create a user
        User::factory()->create($this->newUser);

        $user = $this->userService->getUser('6');
        $this->assertEquals($this->newUser['last_name'], $user->last_name);
        $this->assertEquals($this->newUser['email'], $user->email);
    }

    public function test_createUser_returns_created_user(): void {
        $user = $this->userService->createUser($this->newUser);
        $this->assertEquals($this->newUser['last_name'], $user->last_name);
        $this->assertEquals($this->newUser['first_name'], $user->first_name);
        $this->assertEquals($this->newUser['email'], $user->email);
        $this->assertEquals($this->newUser['date_of_birth'], $user->date_of_birth);
    }
}
