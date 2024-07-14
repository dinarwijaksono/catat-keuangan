<?php

namespace App\Services;

use App\Models\StartDate;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $user;

    public function boot($user)
    {
        $this->user = $user;

        Log::withContext([
            'class' => UserService::class,
            'user_id' => $this->user->id,
            'user_email' => $this->user->email,
        ]);
    }

    // create
    public function setStartDate(User $user, int $startDate): void
    {
        self::boot($user);

        try {

            StartDate::insert([
                'user_id' => $user->id,
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
    public function getStartDate(User $user): object
    {
        self::boot($user);

        try {
            $startDate = StartDate::select('id', 'user_id', 'date', 'created_at', 'updated_at')
                ->where('user_id', $user->id)
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
    public function updateStartDate(User $user, int $date): void
    {
        self::boot($user);

        try {
            StartDate::where('user_id', $user->id)
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
