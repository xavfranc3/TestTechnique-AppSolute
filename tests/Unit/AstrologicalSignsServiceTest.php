<?php

namespace Tests\Unit;

use App\Services\AstrologicalSignsService;
use Tests\TestCase;

class AstrologicalSignsServiceTest extends TestCase
{
    private AstrologicalSignsService $astrologyService;
    public function setUp(): void
    {
        parent::setUp();
        $this->astrologyService = new AstrologicalSignsService();
    }

    /**
     * Get chinese sign from date of birth
     *
     * @return void
     */
    public function test_getChineseSign_should_return_monkey()
    {
        $dobString = '12-01-05';
        $this->assertEquals('Monkey', $this->astrologyService->getChineseSign($dobString));
    }
    public function test_getChineseSign_should_return_dog()
    {
        $dobString = '1202-01-05';
        $this->assertEquals('Dog', $this->astrologyService->getChineseSign($dobString));
    }
    public function test_getChineseSign_should_return_goat()
    {
        $dobString = '2411-01-05';
        $this->assertEquals('Goat', $this->astrologyService->getChineseSign($dobString));
    }

    /**
     * Get horoscope sign from date of birth
     *
     * @return void
     */
    public function test_getZodiacSign_should_return_capricorn()
    {
        $dobString = '12-12-21';
        $this->assertEquals('Capricorn', $this->astrologyService->getZodiacSign($dobString));
    }
    public function test_getZodiacSign_should_return_taurus()
    {
        $dobString = '1202-05-20';
        $this->assertEquals('Taurus', $this->astrologyService->getZodiacSign($dobString));
    }
    public function test_getZodiacSign_should_return_cancer()
    {
        $dobString = '2411-07-21';
        $this->assertEquals('Cancer', $this->astrologyService->getZodiacSign($dobString));
    }
}
