<?php

namespace Tests\Feature\Livewire\Report;

use App\Livewire\Report\BoxTotalCategoryByPeriod;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxTotalCategoryByPeriodTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
        $this->user = User::select('*')->first();

        $this->actingAs($this->user);

        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);

        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
    }

    public function test_renders_successfully()
    {
        Livewire::test(BoxTotalCategoryByPeriod::class)
            ->assertStatus(200);
    }
}
