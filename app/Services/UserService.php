<?php

namespace App\Services;

use App\Models\StartDate;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function boot()
    {
        Log::withContext([
            'class' => UserService::class,
            'user_id' => auth()->user()->id,
            'user_email' => auth()->user()->email,
        ]);
    }

    // create
    public function setStartDate(int $userId, int $startDate): void
    {
        self::boot();

        try {

            StartDate::insert([
                'user_id' => $userId,
                'date' => $startDate,
                'created_at' => round(microtime(true) * 1000),
                'updated_at' => round(microtime(true) * 1000),
            ]);

            Log::info('set start date success');
        } catch (\Throwable $th) {
            Log::error('set start date success', [
                'message' => $th->getMessage()
            ]);
        }
    }

    // read
    public function getStartDate(int $userId): object
    {
        self::boot();

        try {
            $startDate = StartDate::select('id', 'user_id', 'date', 'created_at', 'updated_at')
                ->where('user_id', $userId)
                ->first();

            Log::info("get start date success");

            return $startDate;
        } catch (\Throwable $th) {
            Log::error('get start date failed', [
                'message' => $th->getMessage()
            ]);
        }
    }


    // update
    public function updateStartDate(int $userId, int $date): void
    {
        self::boot();

        try {
            StartDate::where('user_id', $userId)
                ->update([
                    'date'  => $date,
                    'updated_at' => round(microtime(true) * 1000)
                ]);

            Log::info('update start date success');
        } catch (\Throwable $th) {
            Log::error('update start date failed', [
                'message' => $th->getMessage()
            ]);
        }
    }
}
