<?php

namespace Tests\Feature\Services;

use App\Domains\TransactionDomain;
use App\Models\Category;
use App\Models\User;
use App\Services\PeriodService;
use App\Services\TransactionService;
use Database\Seeders\CategorySeeder;
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
        $periodId = $this->periodService->createGetId($this->user, 1, 2024);

        $transactionDomain = new TransactionDomain();
        $transactionDomain->userId = $this->user->id;
        $transactionDomain->categoryId = $this->category->id;
        $transactionDomain->periodId = $periodId;
        $transactionDomain->date = mktime(1, 1, 1, 1, 20, 2024);
        $transactionDomain->description = 'Makan malam';
        $transactionDomain->income = 0;
        $transactionDomain->spending = 20000;

        $this->transactionService->create($this->user, $transactionDomain);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'period_id' => $periodId,
            'date' => mktime(0, 0, 0, 1, 20, 2024),
            'description' => 'makan malam',
            'income' => 0,
            'spending' => 20000
        ]);
    }
}
