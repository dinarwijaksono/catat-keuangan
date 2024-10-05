<?php

namespace App\Services;

use App\Models\StartDate;
use App\Models\User;
use App\Repository\TokenRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class UserService
{
    protected $tokenRepository;

    protected $user;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

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
    public function checkTokenExpired(string $token): bool
    {
        try {
            Log::info('check token success');

            return $this->tokenRepository->checkExpired($token);
        } catch (\Throwable $th) {
            Log::error('check token expired failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

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

    public function getByToken(string $token): stdClass | null
    {
        try {
            $user = DB::table('api_tokens')
                ->join('users', 'users.id', '=', 'api_tokens.user_id')
                ->join('start_dates', 'start_dates.user_id', '=', 'api_tokens.user_id')
                ->select(
                    'users.id',
                    'start_dates.date as start_date',
                    'users.name',
                    'users.email',
                    'users.created_at',
                    'users.updated_at'
                )
                ->where('api_tokens.token', $token)
                ->first();

            if (!$user) {
                throw new ModelNotFoundException("token not found in database");
            }

            Log::info('get user by token success', [
                'api-token' => $token,
                'email' => $user->email
            ]);

            return $user;
        } catch (\Throwable $th) {
            Log::error('get user by token failed', [
                'api-token' => $token,
                'message' => $th->getMessage()
            ]);

            return null;
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
