<?php

namespace Tests\Feature\Services;

use App\Domains\TransactionDomain;
use App\Models\Category;
use App\Models\Period;
use App\Models\Transaction;
use App\Models\User;
use App\Services\PeriodService;
use App\Services\TransactionService;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    public $user;
    public $category;

    public $transactionService;
    public $periodService;

    public function setUp(): void
    {
        parent::setUp();

        $this->transactionService = $this->app->make(TransactionService::class);
        $this->periodService = $this->app->make(PeriodService::class);

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();

        $this->seed(CategorySeeder::class);
        $this->category = Category::select('*')->first();
    }

    public function test_create(): void
    {
        $transactionDomain = new TransactionDomain();
        $transactionDomain->userId = $this->user->id;
        $transactionDomain->categoryId = $this->category->id;
        $transactionDomain->date = strtotime("2024-01-20");
        $transactionDomain->description = 'Makan malam';
        $transactionDomain->income = 0;
        $transactionDomain->spending = 20000;

        $this->transactionService->create($transactionDomain);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'date' => mktime(0, 0, 0, 1, 20, 2024),
            'description' => 'makan malam',
            'income' => 0,
            'spending' => 20000
        ]);
    }

    public function test_get_by_code()
    {
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);

        $transaction = Transaction::select('*')->first();

        $response = $this->transactionService->getByCode($this->user, $transaction->code);

        $this->assertEquals($transaction->date, $response->date);
        $this->assertEquals($transaction->description, $response->description);
    }

    public function test_get_by_date()
    {
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);

        $transaction = Transaction::select('*')->first();

        $response = $this->transactionService->getByDate($this->user, $transaction->date);

        $response = $response->first();
        $this->assertObjectHasProperty('code', $response);
        $this->assertObjectHasProperty('period_date', $response);
        $this->assertObjectHasProperty('period_name', $response);
        $this->assertObjectHasProperty('category_code', $response);
        $this->assertObjectHasProperty('category_name', $response);
        $this->assertObjectHasProperty('category_type', $response);
        $this->assertObjectHasProperty('date', $response);
        $this->assertObjectHasProperty('description', $response);
        $this->assertObjectHasProperty('income', $response);
        $this->assertObjectHasProperty('spending', $response);
        $this->assertObjectHasProperty('created_at', $response);
        $this->assertObjectHasProperty('updated_at', $response);
    }

    public function test_get_recent()
    {
        for ($i = 0; $i < 100; $i++) {
            $this->seed(TransactionSeeder::class);
        }

        $response = $this->transactionService->getRecent($this->user);

        $this->assertIsObject($response);

        $first = $response->first();
        $this->assertObjectHasProperty('total_income', $first);
        $this->assertObjectHasProperty('total_spending', $first);
    }

    public function test_get_by_category()
    {
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);

        $transaction = Transaction::select('*')->first();

        $response =  $this->transactionService->getByCategory($this->user, $transaction->category_id);

        $response = $response->first();
        $this->assertObjectHasProperty('code', $response);
        $this->assertObjectHasProperty('period_date', $response);
        $this->assertObjectHasProperty('period_name', $response);
    }

    public function test_get_by_period()
    {
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);

        $transaction = Transaction::select('*')->first();
        $response = $this->transactionService->getByPeriod($this->user->id, $transaction->period_id);

        $tran = $response->first();
        $this->assertObjectHasProperty('code', $tran);
        $this->assertObjectHasProperty('period_date', $tran);
        $this->assertObjectHasProperty('period_name', $tran);
        $this->assertObjectHasProperty('category_code', $tran);
        $this->assertObjectHasProperty('category_name', $tran);
    }

    public function test_update()
    {
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);

        $category = Category::select('*')->whereOr('code',  '!=', $this->category->code)->first();

        $transactionFirst = Transaction::select('*')->first();

        $periodId = $this->periodService->createGetId($this->user, 1, 2024);

        $transaction = new TransactionDomain();
        $transaction->code = $transactionFirst->code;
        $transaction->categoryId = $category->id;
        $transaction->periodId = $periodId;
        $transaction->date = mktime(1, 1, 1, 1, 20, 2024);
        $transaction->description = 'lontong';
        $transaction->income = $category->type == 'income' ? 20000 : 0;
        $transaction->spending = $category->type == 'spending' ? 20000 : 0;

        $this->transactionService->update($this->user, $transaction);

        $this->assertDatabaseHas('transactions', [
            'code' => $transactionFirst->code,
            'description' => 'lontong',
            'date' => mktime(0, 0, 0, 1, 20, 2024),
            'category_id' => $category->id,
            'period_id' => $periodId,
            'income' => $category->type == 'income' ? 20000 : 0,
            'spending' => $category->type == 'spending' ? 20000 : 0,
        ]);
    }

    public function test_delete()
    {
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);

        $transaction = Transaction::select('*')->first();

        $this->transactionService->delete($this->user, $transaction->code);

        $this->assertDatabaseMissing('transactions', [
            'code' => $transaction->code
        ]);
    }
}
