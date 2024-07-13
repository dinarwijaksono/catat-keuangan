<?php

namespace App\Services;

use App\Domains\TransactionDomain;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    public function boot()
    {
        Log::withContext([
            'class' => TransactionService::class,
            'user_id' => auth()->user()->id,
            'user_email' => auth()->user()->email,
        ]);
    }

    // create
    public function create(TransactionDomain $transactionDomain): void
    {
        self::boot();

        try {

            $day = date('j', $transactionDomain->date);
            $month = date('n', $transactionDomain->date);
            $year = date('Y', $transactionDomain->date);

            Transaction::insert([
                'user_id' => $transactionDomain->userId,
                'category_id' => $transactionDomain->categoryId,
                'period_id' => $transactionDomain->periodId,
                'code' => 'T' . random_int(1, 999999999),
                'date' => mktime(0, 0, 0, $month, $day, $year),
                'description' => strtolower($transactionDomain->description),
                'income' => $transactionDomain->income,
                'spending' => $transactionDomain->spending,
                'created_at' => round(microtime(true) * 1000),
                'updated_at' => round(microtime(true) * 1000),
            ]);

            Log::info('create transaction success');
        } catch (\Throwable $th) {
            Log::error('create transaction failed', [
                'message' => $th->getMessage()
            ]);
        }
    }
}