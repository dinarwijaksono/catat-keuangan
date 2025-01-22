<?php

namespace Tests\Feature\Http\ControllerApi;

use App\Models\ApiToken;
use App\Models\User;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
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
            'errors' => ['general']
        ]);
        $response->assertJsonPath('errors.general', "Email has already exist.");
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

    public function test_get_current_user_success()
    {
        $this->seed(UserRegisterSeeder::class);

        $t = ApiToken::select('*')->first();

        $response = $this->withHeaders([
            'api-token' => $t->token
        ])->get("/api/current-user");

        $response->assertStatus(200);
        $this->assertIsObject($response);

        $response->assertJsonStructure([
            'data' => ['name', 'email', 'start_date', 'created_at', 'updated_at']
        ]);
    }

    public function test_get_current_user_but_token_is_wrong()
    {
        $this->seed(UserRegisterSeeder::class);

        $response = $this->withHeaders([
            'api-token' => 'abcefh'
        ])->get("/api/current-user");

        $response->assertStatus(401);

        $response->assertJsonStructure(['message']);
        $response->assertJsonPath('message', 'Token salah.');
    }

    public function test_get_current_user_but_token_has_expired()
    {
        $this->seed(UserRegisterSeeder::class);
        $t = ApiToken::first();

        ApiToken::where('token', $t->token)->update([
            'expired_at' => round(microtime(true)) - 10 * 1000
        ]);

        $response = $this->withHeaders([
            'api-token' => $t->token
        ])->get("/api/current-user");

        $response->assertStatus(401);
        $response->assertJsonPath('message', 'Token expired.');
    }

    public function test_logout_success()
    {
        $this->seed(UserRegisterSeeder::class);
        $t = ApiToken::first();

        $response = $this->withHeader('api-token', $t->token)
            ->delete('/api/logout');

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Berhasil');
    }
}
