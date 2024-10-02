<?php

namespace App\Services;

use App\Models\Period;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeriodService
{
    protected $user;

    public function boot(User $user)
    {
        $this->user = $user;

        Log::withContext([
            'class' => PeriodService::class,
            'user_id'  => $this->user->id,
            'user_email'  => $this->user->email,
        ]);
    }

    // create
    public function createGetId(User $user, int $month, int $year): int
    {
        self::boot($user);

        try {
            $date = mktime(0, 0, 0, $month, 1, $year);

            $id = DB::table('periods')->insertGetId([
                'user_id' => $user->id,
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
    public function checkIsEmpty(User $user, int $month, int $year): bool
    {
        self::boot($user);

        try {
            $period = Period::select('id')
                ->where('user_id', $user->id)
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

    public function getByMonthYear($user, int $month, int $year): object
    {
        self::boot($user);

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
                ->where('user_id', $user->id)
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

    public function getAll(User $user): Collection | null
    {
        try {
            $period = Period::select(
                'id',
                'period_date',
                'period_name',
                'is_close',
                'created_at',
                'updated_at'
            )
                ->where('user_id', $user->id)
                ->orderByDesc('period_date')
                ->get();

            Log::info('get all period success');

            return $period->isEmpty() ? null : $period;
        } catch (\Throwable $th) {
            Log::error('get all period failed', [
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }
}
