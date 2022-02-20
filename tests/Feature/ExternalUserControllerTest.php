<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExternalUserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $httpHeaders;

    public function setUp(): void
    {
        parent::setUp();
        $this->initDatabase();
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

    public function test_create_external_user_route_creates_new_user(): void {
        $response = $this->call(
            'GET',
            '/api/external_user',
            [],
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
    }
}
