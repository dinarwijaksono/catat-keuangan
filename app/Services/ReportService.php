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
}
