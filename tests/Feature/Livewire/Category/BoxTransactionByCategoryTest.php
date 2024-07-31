<?php

namespace Tests\Feature\Livewire\Category;

use App\Livewire\Category\BoxTransactionByCategory;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxTransactionByCategoryTest extends TestCase
{
    public $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);
        $user = User::select('*')->first();
        $this->actingAs($user);

        $this->seed(CategorySeeder::class);
        $this->category = Category::select("*")->first();

        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
    }

    public function test_renders_successfully()
    {
        Livewire::test(BoxTransactionByCategory::class, ['categoryCode' => $this->category->code])
            ->assertStatus(200);
    }
}
