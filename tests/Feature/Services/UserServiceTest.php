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

        $this->userService = $this->app->make(UserService::class);

        $this->user = User::select('*')->first();
        $this->actingAs($this->user);
    }

    public function test_set_start_date(): void
    {
        $this->userService->setStartDate($this->user->id, 10);

        $this->assertDatabaseHas('start_dates', [
            'user_id' => $this->user->id,
            'date' => 10
        ]);
    }
}
