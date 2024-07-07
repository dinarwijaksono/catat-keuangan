<?php

namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\CategoryService;
use Database\Seeders\CategorySeeder;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    public $user;

    public $categoryService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();
        $this->actingAs($this->user);

        $this->categoryService = $this->app->make(CategoryService::class);
    }

    public function test_create(): void
    {
        $name = 'Example name';
        $type = 'spending';

        $this->categoryService->create($this->user->id, $name, $type);

        $this->assertDatabaseHas('categories', [
            'user_id' => $this->user->id,
            'name' => $name,
            'type' => $type
        ]);
    }


    public function test_get_all()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);

        $response = $this->categoryService->getAll($this->user->id);

        $this->assertIsObject($response);
        $this->assertEquals($response->count(), 3);
    }
}
