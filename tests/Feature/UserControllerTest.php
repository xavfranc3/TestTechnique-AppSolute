<?php

namespace Tests\Feature;

use App\Models\User;
use App\Utils\AppConstants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
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
    public function test_index_function_returns_200_status() {

        $response = $this->get('/api/users');
        $response
            ->assertStatus(200);
    }

    public function test_index_function_paginates_correctly() {

        User::factory()->count(7)->create();

        $response = $this->get('/api/users');

        $response
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->has('users')
                    ->count('users.data', 5);
            });
    }

    /**
     * Testing show function
     */
    public function test_show_function_has_userDetails_chineseSign_zodiacSign() {

        User::factory()->count(7)->create();
        User::factory()->create($this->newUser);

        $response = $this->get('/api/users/8');

        $response
            ->assertJsonStructure([
                'userDetails' => [
                    'id',
                    'first_name',
                    'last_name',
                    'date_of_birth',
                    'created_at',
                    'updated_at',
                    'email'
                ],
                'chineseSign',
                'zodiacSign'
            ]);
        $this->assertEquals($this->newUser['email'], $response['userDetails']['email']);
    }

}
