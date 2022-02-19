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
    protected array $httpHeaders;

    public function setUp(): void
    {
        parent::setUp();
        $this->initDatabase();
        $this->newUser = AppConstants::NEW_USER;
        $this->httpHeaders = [
            'HTTP_Authorization' => 'Basic' . base64_encode(env('BASIC_AUTH_USERNAME') . ':' . env('BASIC_AUTH_PASSWORD')),
            'PHP_AUTH_USER' => env('BASIC_AUTH_USERNAME'),
            'PHP_AUTH_PW' => env('BASIC_AUTH_PASSWORD')
        ];
    }
    public function tearDown(): void
    {
        $this->resetDatabase();
        parent::tearDown();
    }

    /**
     * Testing index function
     */
    public function test_index_function_with_auth_header_responds_with_200_status() {
        $response = $this->call(
            'GET',
            '/api/users',
            [],
            [],
            [],
            $this->httpHeaders
        );

        $response->assertStatus(200);
    }

    public function test_index_function_without_auth_header_responds_with_401_status() {
       $response = $this->call('GET', '/api/users');

       $response->assertStatus(401);
    }


    public function test_index_function_sends_correct_response_structure() {

        User::factory()->count(7)->create();

        $response = $this->call(
            'GET',
            '/api/users',
            [],
            [],
            [],
            $this->httpHeaders
        );

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
    public function test_show_function_with_auth_header_responds_with_200_status() {

        User::factory()->count(7)->create();
        User::factory()->create($this->newUser);

        $response = $this->call(
            'GET',
            '/api/users/1',
            [],
            [],
            [],
            $this->httpHeaders
        );

        $response->assertStatus(200);
    }

    public function test_show_function_without_auth_header_responds_with_401_status() {

        User::factory()->count(7)->create();
        User::factory()->create($this->newUser);

        $response = $this->call(
            'GET',
            '/api/users/1'
        );

        $response->assertStatus(401);
    }

    public function test_show_function_sends_accurate_response() {

        User::factory()->count(7)->create();
        User::factory()->create($this->newUser);

        $response = $this->call(
            'GET',
            '/api/users/8',
            [],
            [],
            [],
            $this->httpHeaders
        );

        $response
            ->assertJsonStructure([
                'data' =>
                    ['userDetails' =>
                        [
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

    public function test_store_function_with_auth_header_responds_with_200_status() {

        $response = $this->call(
                'POST',
                '/api/users',
                $this->newUser,
                [],
                [],
                $this->httpHeaders
        );

        $response->assertStatus(200);
    }

    public function test_store_function_without_auth_header_responds_with_401_status() {

        User::factory()->count(7)->create();
        User::factory()->create($this->newUser);

        $response = $this->call(

            'POST',
            '/api/users',
            $this->newUser,
            [],
            []
        );

        $response->assertStatus(401);
    }


    public function test_store_function_sends_accurate_response() {

        $response = $this->call(
            'POST',
            '/api/users',
            $this->newUser,
            [],
            [],
            $this->httpHeaders);

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
