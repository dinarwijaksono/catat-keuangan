<?php

namespace Tests\Feature\Repository;

use App\Models\Transaction;
use App\Models\User;
use App\Repository\TransactionRepository;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TransactionRepositoryTest extends TestCase
{
    public $user;
    public $transactionRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->transactionRepository = $this->app->make(TransactionRepository::class);

        $this->seed(UserSeeder::class);
        $this->user = User::first();

        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);
    }


    public function test_get_by_date_returns_correct_transactions(): void
    {
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);

        $tran = Transaction::first();

        $response = $this->transactionRepository->getByDate($this->user->id, $tran->date);

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(1, $response);
        $this->assertEquals($tran->code, $response->first()->code);
        $this->assertEquals($tran->description, $response->first()->description);
        $this->assertEquals($tran->spending, $response->first()->spending);
    }

    public function test_get_by_date_returns_empty_if_no_transactions()
    {
        $transactions = $this->transactionRepository->getByDate(1, strtotime('2024-02-01'));

        $this->assertInstanceOf(Collection::class, $transactions);
        $this->assertCount(0, $transactions);
    }
}
