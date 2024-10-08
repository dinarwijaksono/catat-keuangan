<?php

namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public $user;

    public $userService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
        $this->user = User::select('*')->first();

        $this->userService = $this->app->make(UserService::class);
    }

    public function test_set_start_date(): void
    {
        $this->userService->setStartDate($this->user, 10);

        $this->assertDatabaseHas('start_dates', [
            'user_id' => $this->user->id,
            'date' => 10
        ]);
    }

    public function test_get_start_date()
    {
        $this->userService->setStartDate($this->user, 10);

        $startDate = $this->userService->getStartDate($this->user);

        $this->assertIsObject($startDate);

        $this->assertEquals($startDate->date, 10);
    }

    public function test_update_start_date()
    {
        $this->userService->setStartDate($this->user, 10);
        $this->userService->getStartDate($this->user);

        $this->userService->updateStartDate($this->user, 16);

        $this->assertDatabaseHas('start_dates', [
            'user_id' => $this->user->id,
            'date' => 16
        ]);
    }
}
