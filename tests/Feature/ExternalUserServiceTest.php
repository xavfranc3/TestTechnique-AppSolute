<?php

namespace Tests\Feature;

use App\Services\ExternalUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExternalUserServiceTest extends TestCase
{
    use RefreshDatabase;

    private ExternalUserService $externalUserService;

    public function setUp(): void
    {
        parent::setUp();
        parent::initDatabase();
        $this->externalUserService = new ExternalUserService();
    }

    public function tearDown(): void
    {
        parent::resetDatabase();
        parent::tearDown();
    }

    public function test_if_extract_user_values_returns_correct_structure(): void
    {
        $originalData = json_decode(Http::get('randomuser.me/api'), true);
        $this->assertArrayHasKey('first_name', $this->externalUserService->extractUserValues($originalData));
        $this->assertArrayHasKey('last_name', $this->externalUserService->extractUserValues($originalData));
        $this->assertArrayHasKey('email', $this->externalUserService->extractUserValues($originalData));
        $this->assertArrayHasKey('date_of_birth', $this->externalUserService->extractUserValues($originalData));
    }

    public function test_createExternalUser_returns_created_user_with_correct_structure(): void {
        $this->assertArrayHasKey('first_name', $this->externalUserService->createExternalUser());
        $this->assertArrayHasKey('last_name', $this->externalUserService->createExternalUser());
        $this->assertArrayHasKey('email', $this->externalUserService->createExternalUser());
        $this->assertArrayHasKey('date_of_birth', $this->externalUserService->createExternalUser());
    }
}
