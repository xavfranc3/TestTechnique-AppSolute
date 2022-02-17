<?php

namespace Tests\Feature;

use App\Models\User;
use App\Utils\AppConstants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $newUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->initDatabase();
        $this->newUser = AppConstants::NEW_USER;
    }
    public function tearDown(): void
    {
        $this->resetDatabase();
        parent::tearDown();
    }

    /**
     * Testing index function
     */
    public function test_index_function_sends_correct_response_structure() {

        User::factory()->count(7)->create();

        $response = $this->getJson('/api/users');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => []
            ]);
    }

    /**
     * Testing show function
     */
    public function test_show_function_sends_accurate_response() {

        User::factory()->count(7)->create();
        User::factory()->create($this->newUser);

        $response = $this->getJson('/api/users/8');

        $response
            ->assertJsonStructure([
                'data' => ['userDetails' => [
                            'id',
                            'first_name',
                            'last_name',
                            'date_of_birth',
                            'created_at',
                            'updated_at',
                            'email'
                            ],
                            'chineseSign',
                            'zodiacSign']
            ]);
        $this->assertEquals($this->newUser['email'], $response['data']['userDetails']['email']);
    }

    public function test_store_function_sends_accurate_response() {

        $response = $this->postJson('/api/users', $this->newUser);

        $response
            ->assertJsonStructure([
                'status',
                'data' => [
                            'id',
                            'first_name',
                            'last_name',
                            'date_of_birth',
                            'created_at',
                            'updated_at',
                            'email'
                            ]
            ]);
        $this->assertEquals($this->newUser['email'], $response['data']['email']);
    }

}
