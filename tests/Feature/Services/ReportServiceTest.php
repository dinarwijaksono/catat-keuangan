<?php

namespace Tests\Feature\Services;

use App\Models\Category;
use App\Models\User;
use App\Services\ReportService;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ReportServiceTest extends TestCase
{
    public $user;
    public $category;

    public $reportService;

    public function setUp(): void
    {
        parent::setUp();

        $this->reportService = $this->app->make(ReportService::class);

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();

        $this->seed(CategorySeeder::class);
        $this->category = Category::select('*')->first();

        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
    }

    public function test_get_amount(): void
    {
        $totalIncome = DB::table('transactions')
            ->select(
                DB::raw("sum(income) as total"),
            )->where('user_id', $this->user->id)
            ->first();

        $totalSpending = DB::table('transactions')
            ->select(
                DB::raw("sum(spending) as total"),
            )->where('user_id', $this->user->id)
            ->first();

        $amount = $this->reportService->getAmount($this->user);

        $this->assertEquals($totalIncome->total, $amount->total_income);
        $this->assertEquals($totalSpending->total, $amount->total_spending);
    }
}
