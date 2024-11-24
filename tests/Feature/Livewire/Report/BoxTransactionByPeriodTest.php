<?php

namespace Tests\Feature\Livewire\Report;

use App\Livewire\Report\BoxTransactionByPeriod;
use App\Models\Transaction;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxTransactionByPeriodTest extends TestCase
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
        Livewire::test(BoxTransactionByPeriod::class)
            ->assertStatus(200);
    }

    public function test_delete_transaction()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);

        $transaction = Transaction::first();

        Livewire::test(BoxTransactionByPeriod::class)
            ->call('doDeleteTransaction', $transaction->code);

        $this->assertDatabaseMissing('transactions', [
            'code' => $transaction->code
        ]);
    }
}
