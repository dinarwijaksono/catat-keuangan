<?php

namespace Tests\Feature\Services;

use App\Models\ApiToken;
use App\Models\User;
use App\Services\UserService;
use Database\Seeders\UserRegisterSeeder;
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

    public function test_check_token_expired()
    {
        $this->seed(UserRegisterSeeder::class);

        $t = ApiToken::select('*')->first();

        $this->assertFalse($this->userService->checkTokenExpired($t->token));
    }

    public function test_get_start_date()
    {
        $this->userService->setStartDate($this->user, 10);

        $startDate = $this->userService->getStartDate($this->user);

        $this->assertIsObject($startDate);

        $this->assertEquals($startDate->date, 10);
    }

    public function test_get_by_token_success()
    {
        $this->seed(UserRegisterSeeder::class);

        $t = ApiToken::select('*')->first();

        $response = $this->userService->getByToken($t->token);

        $this->assertIsObject($response);
        $this->assertObjectHasProperty('name', $response);
        $this->assertObjectHasProperty('start_date', $response);
        $this->assertObjectHasProperty('email', $response);
        $this->assertObjectHasProperty('created_at', $response);
    }

    public function test_get_by_token_failed()
    {
        $response = $this->userService->getByToken('abcdedf');

        $this->assertNull($response);
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
