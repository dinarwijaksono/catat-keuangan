<?php

namespace Tests\Feature\Livewire\Transaction;

use App\Livewire\Transaction\FormEditTransaction;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormEditTransactionTest extends TestCase
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
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);
        $this->category = Category::select('*')->get();

        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
    }

    public function test_renders_successfully()
    {
        $transaction = Transaction::select('*')->first();

        Livewire::test(FormEditTransaction::class, ['code' => $transaction->code])
            ->assertStatus(200);
    }

    public function test_do_edit()
    {
        $transaction = Transaction::select('*')->first();

        Livewire::test(FormEditTransaction::class, ['code' => $transaction->code])
            ->set('total', 100000)
            ->call('doEdit');

        $this->assertDatabaseHas('transactions', [
            'code' => $transaction->code,
            'income' => $transaction->income == 0 ? 0 : 100000,
            'spending' => $transaction->spending == 0 ? 0 : 100000,
        ]);
    }
}
