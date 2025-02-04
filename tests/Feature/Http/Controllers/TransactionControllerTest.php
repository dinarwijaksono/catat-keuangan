<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();
        $this->actingAs($this->user);
    }

    public function test_view(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
