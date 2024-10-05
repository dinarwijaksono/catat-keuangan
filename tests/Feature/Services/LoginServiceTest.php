<?php

namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\LoginService;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginServiceTest extends TestCase
{
    public $loginService;

    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->loginService = $this->app->make(LoginService::class);

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();
    }

    public function test_login_success(): void
    {
        $response = $this->loginService->login($this->user->email, 'rahasia');

        $this->assertIsObject($response);
        $this->assertObjectHasProperty('email', $response);
        $this->assertObjectHasProperty('name', $response);
        $this->assertObjectHasProperty('api_token', $response);
        $this->assertObjectHasProperty('token_expired', $response);
        $this->assertObjectHasProperty('start_date', $response);
    }

    public function test_login_failed_email_is_wrong()
    {
        $response = $this->loginService->login('wrong@gmail.com', 'rahasia');

        $this->assertNull($response);
    }

    public function test_login_failed_password_is_wrong()
    {
        $response = $this->loginService->login($this->user->email, 'password wrong');

        $this->assertNull($response);
    }
}
