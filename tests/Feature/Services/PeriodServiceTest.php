<?php

namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\PeriodService;
use Database\Seeders\UserRegisterSeeder;
use Hamcrest\Type\IsInteger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PeriodServiceTest extends TestCase
{
    public $user;

    public $periodService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();

        $this->periodService = $this->app->make(PeriodService::class);
    }

    public function test_create_get_id(): void
    {
        $date = mktime(1, 2, 10, 1, 5, 2023);

        $response = $this->periodService->createGetId($this->user, 1, 2023);

        $this->assertTrue(is_int($response));

        $this->assertDatabaseHas('periods', [
            'id' => $response,
            'user_id' => $this->user->id,
            'period_date' => mktime(0, 0, 0, 1, 1, 2023),
            'period_name' => date('F Y', $date),
            'is_close' => false,
        ]);
    }


    public function test_check_is_empty_return_true()
    {
        $response = $this->periodService->checkIsEmpty($this->user, 1, 2024);

        $this->assertTrue($response);
    }

    public function test_check_is_empty_return_false()
    {
        $this->periodService->createGetId($this->user, 1, 2024);

        $response = $this->periodService->checkIsEmpty($this->user, 1, 2024);

        $this->assertFalse($response);
    }

    public function test_get_by_month_and_year()
    {
        $this->periodService->createGetId($this->user, 1, 2024);

        $response = $this->periodService->getByMonthYear($this->user, 1, 2024);

        $this->assertEquals($response->period_date, mktime(0, 0, 0, 1, 1, 2024));
        $this->assertEquals($response->period_name, date('F Y', mktime(0, 0, 0, 1, 1, 2024)));
        $this->assertEquals($response->is_close, false);
    }
}
