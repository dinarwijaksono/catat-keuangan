<?php

namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\RegisterService;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterServiceTest extends TestCase
{
    public $registerService;

    public function setUp(): void
    {
        parent::setUp();

        $this->registerService = $this->app->make(RegisterService::class);
    }


    public function test_register_success(): void
    {
        $name = 'example';
        $email = 'example@gmail.com';
        $password = 'rahasia';

        $response = $this->registerService->register($name, $email, $password);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
        ]);

        $this->assertDatabaseHas('start_dates', [
            'user_id' => $response['user_id'],
            'date' => 1,
        ]);

        $this->assertDatabaseHas('api_tokens', [
            'user_id' => $response['user_id'],
            'token' => $response['api_token']
        ]);
    }

    public function test_register_failed_email_has_already()
    {
        $this->seed(UserRegisterSeeder::class);
        $user = User::select('*')->first();

        $response = $this->registerService->register("example", $user->email, "rahasia", 'rahasia');

        $this->assertNull($response);
    }
}
