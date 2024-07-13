<?php

namespace App\Services;

use App\Models\Period;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeriodService
{
    public function boot()
    {
        Log::withContext([
            'class' => PeriodService::class,
            'user_id'  => auth()->user()->id,
            'user_email'  => auth()->user()->email,
        ]);
    }

    // create
    public function createGetId(int $userId, int $month, int $year): int
    {
        self::boot();

        try {
            $date = mktime(0, 0, 0, $month, 1, $year);

            $id = DB::table('periods')->insertGetId([
                'user_id' => $userId,
                'period_date' => $date,
                'period_name' => date('F Y', $date),
                'is_close' => false,
                'created_at' => round(microtime(true) * 1000),
                'updated_at' => round(microtime(true) * 1000),
            ]);

            Log::info('create get id success');

            return $id;
        } catch (\Throwable $th) {
            Log::error('create get id failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    // read
    public function checkIsEmpty(int $userId, int $month, int $year): bool
    {
        self::boot();

        try {
            $period = Period::select('id')
                ->where('user_id', $userId)
                ->where('period_date', mktime(0, 0, 0, $month, 1, $year))
                ->get();

            Log::info('check period is empty success');

            return $period->isEmpty();
        } catch (\Throwable $th) {
            Log::error('check period is empty failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getByMonthYear(int $userId, int $month, int $year): object
    {
        self::boot();

        try {
            $period = Period::select(
                'id',
                'user_id',
                'period_date',
                'period_name',
                'is_close',
                'created_at',
                'updated_at'
            )
                ->where('user_id', $userId)
                ->where('period_date', mktime(0, 0, 0, $month, 1, $year))
                ->first();

            Log::info('get period by month and year success');

            return $period;
        } catch (\Throwable $th) {
            Log::error('get period by month and year failed', [
                'message' => $th->getMessage()
            ]);
        }
    }
}
