<?php

namespace App\Repository;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    public function getByDate(int $userId, int $date): Collection
    {
        return DB::table('transactions')
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
            ->where('transactions.user_id', $userId)
            ->where('transactions.date', $date)
            ->get();
    }
}
