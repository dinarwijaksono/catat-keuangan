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


    public function setStartDate(int $userId, int $startDate): void
    {
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
}
