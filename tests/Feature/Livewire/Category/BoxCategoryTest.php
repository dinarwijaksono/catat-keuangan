<?php

namespace Tests\Feature\Livewire\Category;

use App\Livewire\Category\BoxCategory;
use App\Livewire\Component\AlertSuccess;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxCategoryTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();
        $this->actingAs($this->user);

        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);
    }

    public function test_renders_successfully()
    {
        Livewire::test(BoxCategory::class)
            ->assertStatus(200);
    }

    public function test_do_delete()
    {
        $category = Category::select('*')->first();

        Livewire::test(BoxCategory::class)
            ->call('doDelete', $category->code)
            ->assertDispatched('delete-category')
            ->assertDispatchedTo(AlertSuccess::class, 'alert-show');

        $this->assertDatabaseMissing('categories', [
            'code' => $category->code
        ]);
    }
}
