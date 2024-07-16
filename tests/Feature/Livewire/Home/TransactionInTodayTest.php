<?php

namespace Tests\Feature\Livewire\Home;

use App\Livewire\Component\AlertSuccess;
use App\Livewire\Home\TransactionInToday;
use App\Models\Transaction;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TransactionInTodayTest extends TestCase
{
    public $user;
    public $transactionFirst;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();
        $this->actingAs($this->user);

        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);

        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);

        $this->transactionFirst = Transaction::select('*')->first();
    }

    public function test_renders_successfully()
    {
        Livewire::test(TransactionInToday::class)
            ->assertStatus(200)
            ->assertSeeHtml("<h2 class='title'>Transaksi Hari Ini</h2>");
    }

    public function test_do_delete()
    {
        Livewire::test(TransactionInToday::class)
            ->call('doDelete', $this->transactionFirst->code)
            ->assertDispatchedTo(AlertSuccess::class, 'alert-show')
            ->assertDispatched('delete-success');

        $this->assertDatabaseMissing('transactions', [
            'code' => $this->transactionFirst->code
        ]);
    }
}
