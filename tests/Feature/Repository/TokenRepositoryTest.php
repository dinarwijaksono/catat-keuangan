<?php

namespace Tests\Feature\Repository;

use App\Models\ApiToken;
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

    public function test_create_success(): void
    {
        $response = $this->tokenRespository->create($this->user->email);

        $this->assertIsString($response);

        $this->assertDatabaseHas('api_tokens', [
            'user_id' => $this->user->id,
            'token' => $response,
        ]);
    }

    public function test_create_failed()
    {
        $response = $this->tokenRespository->create("email@gmail.com");

        $this->assertNull($response);
    }

    public function test_check_expired_true()
    {
        $t = $this->tokenRespository->create($this->user->email);

        ApiToken::where('token', $t)->update([
            'expired_at' => (microtime(true) * 1000) - (10 * 60 * 60 * 1000)
        ]);

        $response = $this->tokenRespository->checkExpired($t);

        $this->assertTrue($response);
    }

    public function test_check_expired_false()
    {
        $t = $this->tokenRespository->create($this->user->email);

        $response = $this->tokenRespository->checkExpired($t);

        $this->assertFalse($response);
    }
}
