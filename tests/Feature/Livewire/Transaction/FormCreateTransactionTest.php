<?php

namespace Tests\Feature\Livewire\Transaction;

use App\Livewire\Transaction\FormCreateTransaction;
use App\Models\Category;
use App\Models\User;
use App\Services\CategoryService;
use Database\Seeders\CategorySeeder;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormCreateTransactionTest extends TestCase
{
    public $user;
    public $category;

    public $categoryService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();
        $this->actingAs($this->user);

        $this->seed(CategorySeeder::class);
        $this->categoryService = $this->app->make(CategoryService::class);
        $this->category = Category::select('*')->first();
    }

    public function test_renders_successfully()
    {
        Livewire::test(FormCreateTransaction::class)
            ->assertStatus(200);
    }

    public function test_do_create_transaction_period_new()
    {
        Livewire::test(FormCreateTransaction::class)
            ->set('date', '2024-03-05')
            ->set('type', $this->category->type)
            ->set('category', $this->category->id)
            ->set('total', 10000)
            ->set('description', 'makan malam')
            ->call('doCreateTransaction');

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'date' => strtotime('2024-03-05'),
            'category_id' => $this->category->id,
            'description' => 'makan malam',
            'income' => $this->category->type == 'income' ? 10000 : 0,
            'spending' => $this->category->type == 'spending' ? 10000 : 0,
        ]);
    }

    public function test_do_create_transaction_period_last()
    {
        Livewire::test(FormCreateTransaction::class)
            ->set('date', '2024-03-15')
            ->set('type', $this->category->type)
            ->set('category', $this->category->id)
            ->set('total', 10000)
            ->set('description', 'makanan')
            ->call('doCreateTransaction');

        Livewire::test(FormCreateTransaction::class)
            ->set('date', '2024-03-10')
            ->set('type', $this->category->type)
            ->set('category', $this->category->id)
            ->set('total', 2500)
            ->set('description', 'jajan')
            ->call('doCreateTransaction');

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'date' => strtotime('2024-03-10'),
            'category_id' => $this->category->id,
            'description' => 'jajan',
            'income' => $this->category->type == 'income' ? 2500 : 0,
            'spending' => $this->category->type == 'spending' ? 2500 : 0,
        ]);
    }
}
