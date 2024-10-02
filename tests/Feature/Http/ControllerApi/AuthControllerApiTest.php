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
}
