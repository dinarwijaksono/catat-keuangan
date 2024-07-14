<?php

namespace Database\Seeders;

use App\Domains\TransactionDomain;
use App\Models\Category;
use App\Models\User;
use App\Services\PeriodService;
use App\Services\TransactionService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::select('*')->first();
        $category = Category::select('*')->first();

        $periodService = App::make(PeriodService::class);
        $transactionService = App::make(TransactionService::class);

        $day = random_int(1, 28);
        $month = random_int(1, 12);
        $year = random_int(2000, 2030);

        $transaction = new TransactionDomain();
        $transaction->userId = $user->id;
        $transaction->categoryId = $category->id;
        $transaction->periodId = $periodService->createGetId($user, $month, $year);
        $transaction->date = mktime(0, 0, 0, $month, $day, $year);
        $transaction->description = 'example description ' . random_int(1, 1000);
        $transaction->income = $category->type == 'income' ? random_int(1000, 10000) : 0;
        $transaction->spending = $category->type == 'spending' ? random_int(1000, 10000) : 0;

        $transactionService->create($user, $transaction);
    }
}
