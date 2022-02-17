<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RootTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_app_root_route_returns_a_200_status_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
