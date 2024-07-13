<?php

namespace Tests\Feature\Livewire\Category;

use App\Livewire\Category\FormEditCategory;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormEditCategoryTest extends TestCase
{
    public $user;
    public $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();
        $this->actingAs($this->user);

        $this->seed(CategorySeeder::class);
        $this->category = Category::select('*')->first();
    }

    public function test_renders_successfully()
    {
        Livewire::test(FormEditCategory::class, ['code' => $this->category->code])
            ->assertStatus(200);
    }

    public function test_do_update_failed_validate_is_wrong()
    {
        Livewire::test(FormEditCategory::class, ['code' => $this->category->code])
            ->set('categoryName', '')
            ->call('doUpdate')
            ->assertHasErrors(['categoryName' => 'required']);
    }

    public function test_do_update_success()
    {
        Livewire::test(FormEditCategory::class, ['code' => $this->category->code])
            ->set('categoryName', 'example category name')
            ->call('doUpdate');

        $this->assertDatabaseHas('categories', [
            'name' => 'example category name',
            'code' => $this->category->code
        ]);
    }
}
