<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\ApiToken;
use Database\Seeders\CreateUserWithTokenSeeder;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserWithTokenSeeder::class);

        $this->token = ApiToken::first();
    }

    public function test_create_category_success(): void
    {
        $response = $this->withHeader('api-token', $this->token->token)
            ->post('/api/create-category', [
                'name' => 'makanan',
                'type' => 'spending'
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', [
            'user_id' => $this->token->user_id,
            'name' => 'makanan',
            'type' => 'spending'
        ]);
    }

    public function test_create_category_failed_type_is_wrong()
    {
        $response = $this->withHeader('api-token', $this->token->token)
            ->post('/api/create-category', [
                'name' => 'makanan',
                'type' => 'kkkk'
            ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'Validasi error.');
        $response->assertJsonPath('errors.type', 'Format type salah.');
    }
}
