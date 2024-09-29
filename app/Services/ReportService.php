<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportService
{
    public function getAmount(User $user): object
    {
        try {
            $amount = DB::table('transactions')
                ->select(
                    DB::raw("sum(spending) as total_spending"),
                    DB::raw("sum(income) as total_income"),
                )->where('user_id', $user->id)
                ->first();

            Log::info('get amount success');

            return $amount;
        } catch (\Throwable $th) {
            Log::error('get amount failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getTotalCategoryByPeriod(User $user, int $periodId): Collection
    {
        try {
            $transaction = DB::table('transactions')
                ->join('periods', 'periods.id', '=', 'transactions.period_id')
                ->join('categories', 'categories.id', '=', 'transactions.category_id')
                ->select(
                    DB::raw('SUM(transactions.income) as total_income'),
                    DB::raw('SUM(transactions.spending) as total_spending'),
                    'periods.period_name',
                    'periods.is_close as period_is_close',
                    'categories.name as category_name',
                    'categories.code as category_code'
                )
                ->where('transactions.user_id', $user->id)
                ->where('transactions.period_id', $periodId)
                ->orderByDesc('total_income')
                ->orderByDesc('total_spending')
                ->groupBy(
                    'transactions.category_id',
                    'category_name',
                    'period_name',
                    'period_is_close',
                    'category_code'
                )
                ->get();

            Log::info('get total category by period success');

            return $transaction;
        } catch (\Throwable $th) {
            Log::error('get total category by period failed', [
                'message' => $th->getMessage()
            ]);

            return collect([]);
        }
    }
}
