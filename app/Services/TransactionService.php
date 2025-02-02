<?php

namespace App\Services;

use App\Domains\TransactionDomain;
use App\Models\Transaction;
use App\Models\User;
use App\Repository\PeriodRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    protected $periodRepository;

    public function __construct(PeriodRepository $periodRepository)
    {
        $this->periodRepository = $periodRepository;
    }

    public function boot($user)
    {
        Log::withContext([
            'user_id' => $user->id,
            'user_email' => $user->email,
        ]);
    }

    // create
    public function create(TransactionDomain $transactionDomain): void
    {
        try {
            DB::beginTransaction();

            $period = $this->periodRepository->findOrCreate($transactionDomain->userId, $transactionDomain->date);

            Transaction::create([
                'user_id' => $transactionDomain->userId,
                'category_id' => $transactionDomain->categoryId,
                'period_id' => $period->id,
                'code' => 'T' . random_int(1, 999999999),
                'date' => $transactionDomain->date,
                'description' => strtolower($transactionDomain->description),
                'income' => $transactionDomain->income,
                'spending' => $transactionDomain->spending,
                'created_at' => round(microtime(true) * 1000),
                'updated_at' => round(microtime(true) * 1000),
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('create transaction failed', [
                'user_id' => $transactionDomain->userId,
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

            Log::info('get recent success');

            return $transaction;
        } catch (\Throwable $th) {
            Log::error('get recent failed', [
                'message' => $th->getMessage()
            ]);

            return collect([]);
        }
    }

    public function getByCategory(User $user,  $categoryId): Collection
    {
        try {
            $transaction = DB::table('transactions')
                ->join('periods', 'periods.id', '=', 'transactions.period_id')
                ->select([
                    'transactions.code',
                    'periods.period_date',
                    'periods.period_name',
                    'transactions.date',
                    'transactions.description',
                    'transactions.income',
                    'transactions.spending',
                    'transactions.created_at',
                    'transactions.updated_at'
                ])
                ->where('transactions.user_id', $user->id)
                ->where('transactions.category_id', $categoryId)
                ->orderByDesc('transactions.date')
                ->get();

            Log::info('get transaction by category success', [
                'user_id' => $user->id,
                'user_email' => $user->email,
            ]);

            return $transaction;
        } catch (\Throwable $th) {
            Log::alert('get transaction by category failed', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'message' => $th->getMessage()
            ]);

            return collect([]);
        }
    }

    public function getByPeriod(int $userId, int $periodId): Collection
    {
        $transaction = DB::table('transactions')
            ->join('periods', 'periods.id', '=', 'transactions.period_id')
            ->join('categories', 'categories.id', '=', 'transactions.category_id')
            ->select(
                'transactions.code',
                'periods.period_date',
                'periods.period_name',
                'categories.code as category_code',
                'categories.name as category_name',
                'transactions.date',
                'transactions.description',
                'transactions.income',
                'transactions.spending',
                'transactions.created_at',
                'transactions.updated_at'
            )
            ->where('transactions.user_id', $userId)
            ->where('transactions.period_id', $periodId)
            ->orderByDesc('transactions.date')
            ->get();

        Log::info('get transaction by period success', [
            'user_id' => $userId
        ]);

        return $transaction;
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
