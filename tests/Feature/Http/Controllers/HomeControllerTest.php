<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public $userService;

    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);

        $this->userService = $this->app->make(UserService::class);

        $this->user = User::select('*')->first();
        $this->actingAs($this->user);
    }

    public function test_index(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSeeText($this->user->name);
    }
}
