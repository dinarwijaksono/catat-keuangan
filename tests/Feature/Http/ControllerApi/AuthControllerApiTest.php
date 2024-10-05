<?php

namespace Tests\Feature\Http\ControllerApi;

use App\Models\User;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerApiTest extends TestCase
{
    public function test_register_success(): void
    {
        $name = 'example';
        $email = 'example@gmail.com';

        $response = $this->post('/api/register', [
            'name' => $name,
            'email' => $email,
            'password' => 'rahasia',
            'password_confirm' => 'rahasia'
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => ['api-token', 'email', 'name']
        ]);

        $response->assertJsonPath('data.email', $email);
        $response->assertJsonPath('data.name', $name);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email
        ]);
    }

    public function test_register_email_has_already()
    {
        $this->seed(UserRegisterSeeder::class);
        $user = User::select('*')->first();

        $response = $this->post('/api/register', [
            'name' => 'example',
            'email' => $user->email,
            'password' => 'rahasia',
            'password_confirm' => 'rahasia'
        ]);

        $response->assertStatus(400);

        $response->assertJsonStructure([
            'errors' => ['message']
        ]);
        $response->assertJsonPath('errors.message', "Email has already exist.");
    }

    public function test_login_success()
    {
        $this->seed(UserRegisterSeeder::class);
        $user = User::select('*')->first();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'rahasia'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['email', 'api-token', 'token-expired']
        ]);
        $response->assertJsonPath('data.email', $user->email);
    }

    public function test_login_failed_email_is_wrong()
    {
        $response = $this->post('/api/login', [
            'email' => 'example@gmail.com',
            'password' => 'rahasia'
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'errors' => ['message']
        ]);
        $response->assertJsonPath('errors.message', 'Email or password is wrong.');
    }

    public function test_login_failed_pasword_is_wrong()
    {
        $this->seed(UserRegisterSeeder::class);
        $user = User::select('*')->first();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'salah'
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'errors' => ['message']
        ]);
        $response->assertJsonPath('errors.message', 'Email or password is wrong.');
    }
}
