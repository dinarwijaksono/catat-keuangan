<?php

namespace App\Services;

use App\Domains\TransactionDomain;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    public function boot($user)
    {
        Log::withContext([
            'user_id' => $user->id,
            'user_email' => $user->email,
        ]);
    }

    // create
    public function create(User $user, TransactionDomain $transactionDomain): void
    {
        self::boot($user);

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


    // read
    public function getByCode(User $user, string $code): object
    {
        self::boot($user);

        try {

            $transaction = DB::table('transactions')
                ->join('categories', 'categories.id', '=', 'transactions.category_id')
                ->select([
                    'transactions.code',
                    'categories.id as category_id',
                    'categories.code as category_code',
                    'categories.name as category_name',
                    'categories.type as category_type',
                    'transactions.date',
                    'transactions.description',
                    'transactions.income',
                    'transactions.spending',
                    'transactions.created_at',
                    'transactions.updated_at'
                ])
                ->where('transactions.user_id', $user->id)
                ->where('transactions.code', $code)
                ->first();

            Log::info('get transaction by code success');

            return $transaction;
        } catch (\Throwable $th) {
            Log::error('get transaction by code failed', [
                'message' => $th->getMessage()
            ]);

            return collect([]);
        }
    }

    public function getByDate(User $user, $date): Collection
    {
        self::boot($user);

        try {
            $day = date('j', $date);
            $month = date('n', $date);
            $year = date('Y', $date);

            $date = mktime(0, 0, 0, $month, $day, $year);

            $transaction = DB::table('transactions')
                ->join('periods', 'periods.id', '=', 'transactions.period_id')
                ->join('categories', 'categories.id', '=', 'transactions.category_id')
                ->select([
                    'transactions.code',
                    'periods.period_date',
                    'periods.period_name',
                    'categories.code as category_code',
                    'categories.name as category_name',
                    'categories.type as category_type',
                    'transactions.date',
                    'transactions.description',
                    'transactions.income',
                    'transactions.spending',
                    'transactions.created_at',
                    'transactions.updated_at'
                ])
                ->where('transactions.user_id', $user->id)
                ->where('transactions.date', $date)
                ->get();

            Log::info('get transaction by date success');

            return $transaction;
        } catch (\Throwable $th) {
            Log::error('get transaction by date failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getRecent(User $user): Collection
    {
        self::boot($user);

        try {
            $transaction = DB::table('transactions')
                ->select(
                    'date',
                    DB::raw('sum(spending) as total_spending'),
                    DB::raw('sum(income) as total_income')
                )->groupBy('date')
                ->where('user_id', $user->id)
                ->orderByDesc('date')
                ->skip(0)
                ->take(30)
                ->get();

            Log::info('get success');

            return $transaction;
        } catch (\Throwable $th) {
            Log::error('get failed', [
                'message' => $th->getMessage()
            ]);

            return collect([]);
        }
    }

    // update
    public function update(User $user, TransactionDomain $transactionDomain): void
    {
        self::boot($user);

        try {

            $day = date('j', $transactionDomain->date);
            $month = date('n', $transactionDomain->date);
            $year = date('Y', $transactionDomain->date);

            Transaction::where('code', $transactionDomain->code)
                ->update([
                    'category_id' => $transactionDomain->categoryId,
                    'period_id' => $transactionDomain->periodId,
                    'date' => mktime(0, 0, 0, $month, $day, $year),
                    'description' => strtolower($transactionDomain->description),
                    'income' => $transactionDomain->income,
                    'spending' => $transactionDomain->spending,
                    'updated_at' => round(microtime(true) * 1000),
                ]);

            Log::info('update transaction success');
        } catch (\Throwable $th) {
            Log::error('update transaction failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    // delete
    public function delete(User $user, $transactionCode): void
    {
        self::boot($user);

        try {
            Transaction::where('code', $transactionCode)
                ->delete();

            Log::info('delete transaction success');
        } catch (\Throwable $th) {
            Log::error('delete transaction failed');
        }
    }
}
