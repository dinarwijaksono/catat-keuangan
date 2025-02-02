<?php

namespace Tests\Feature\Repository;

use App\Models\User;
use App\Repository\PeriodRepository;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PeriodRepositoryTest extends TestCase
{
    public $user;

    public $periodRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
        $this->user = User::first();

        $this->periodRepository = $this->app->make(PeriodRepository::class);
    }

    public function test_create_success()
    {
        $date = strtotime("2000-01-01");

        $response = $this->periodRepository->create($this->user->id, $date);

        $this->assertDatabaseHas('periods', [
            'user_id' => $this->user->id,
            'period_date' => $date,
            'period_name' => date('F Y', $date)
        ]);

        $this->assertIsObject($response);
        $this->assertEquals($response->user_id, $this->user->id);
    }

    public function test_find_or_create_create()
    {
        $date = strtotime("2000-01-01");

        $this->periodRepository->create($this->user->id, $date);

        $response = $this->periodRepository->findOrCreate($this->user->id, $date);

        $this->assertEquals($response->user_id, $this->user->id);
        $this->assertEquals($response->period_name, "January 2000");
    }

    public function test_check_is_empty_missing()
    {
        $date = strtotime("2000-01-01");

        $response = $this->periodRepository->findOrCreate($this->user->id, $date);

        $this->assertEquals($response->user_id, $this->user->id);
        $this->assertEquals($response->period_name, "January 2000");
    }
}
