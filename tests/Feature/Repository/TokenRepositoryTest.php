<?php

namespace Tests\Feature\Repository;

use App\Models\User;
use App\Repository\TokenRepository;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TokenRepositoryTest extends TestCase
{
    public $tokenRespository;
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->tokenRespository = $this->app->make(TokenRepository::class);

        $this->seed(UserSeeder::class);
        $this->user = User::select('*')->first();
    }

    public function test_create(): void
    {
        $response = $this->tokenRespository->create($this->user);

        $this->assertIsString($response);

        $this->assertDatabaseHas('api_tokens', [
            'user_id' => $this->user->id,
            'token' => $response,
        ]);
    }
}
