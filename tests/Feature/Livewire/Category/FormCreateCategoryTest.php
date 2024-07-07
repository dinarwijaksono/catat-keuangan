<?php

namespace Tests\Feature\Livewire\Category;

use App\Livewire\Category\BoxCategory;
use App\Livewire\Category\FormCreateCategory;
use App\Livewire\Component\AlertSuccess;
use App\Models\User;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormCreateCategoryTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();
        $this->actingAs($this->user);
    }

    public function test_renders_successfully()
    {
        Livewire::test(FormCreateCategory::class)
            ->assertStatus(200);
    }

    public function test_do_create_category_failed_validate_is_wrong()
    {
        Livewire::test(FormCreateCategory::class)
            ->set('categoryName', '')
            ->set('type', '')
            ->call('doCreateCategory')
            ->assertHasErrors(['categoryName' => 'required', 'type' => 'required']);

        Livewire::test(FormCreateCategory::class)
            ->set('categoryName', 'dd')
            ->set('type', 'spending')
            ->call('doCreateCategory')
            ->assertHasErrors(['categoryName' => 'min:3']);
    }

    public function test_do_create_category_success()
    {
        $categoryName = 'Category-' . random_int(1, 1000);

        Livewire::test(FormCreateCategory::class)
            ->set('categoryName', $categoryName)
            ->set('type', 'income')
            ->call('doCreateCategory')
            ->assertDispatchedTo(AlertSuccess::class, 'alert-hide')
            ->assertDispatchedTo(BoxCategory::class, 'create-category')
            ->assertDispatchedTo(AlertSuccess::class, 'alert-show');

        $this->assertDatabaseHas('categories', [
            'user_id' => $this->user->id,
            'name' => $categoryName,
            'type' => 'income'
        ]);
    }
}
