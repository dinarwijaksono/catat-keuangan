<?php

namespace App\Repository;

use App\Models\StartDate;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository
{
    // create
    public function create(string $name, string $email, string $password): User
    {
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            Log::info("insert user to database success", [
                'email' => $email,
            ]);

            return $user;
        } catch (\Throwable $th) {
            Log::error("insert user to database failed", [
                'email' => $email,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function setStartDate(User $user, int $startDate): void
    {
        try {
            StartDate::insert([
                'user_id' => $user->id,
                'date' => $startDate,
                'created_at' => round(microtime(true) * 1000),
                'updated_at' => round(microtime(true) * 1000),
            ]);

            Log::info('insert start date to database success', [
                'email' => $user->email,
            ]);
        } catch (\Throwable $th) {
            Log::error('insert start date to database failed', [
                'email' => $user->email,
                'message' => $th->getMessage()
            ]);
        }
    }

    // read
    public function checkByEmail(string $email): bool
    {
        $user = User::select('email')->where('email', $email)->get();

        return !$user->isEmpty();
    }

    public function checkPassword(string $email, string $password): bool
    {
        $user = User::select('password')
            ->where('email', $email)
            ->first();

        return Hash::check($password, $user->password);
    }

    public function getByEmail(string $email): Object
    {
        $user = DB::table('users')
            ->join('api_tokens', 'api_tokens.user_id', '=', 'users.id')
            ->join('start_dates', 'start_dates.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'api_tokens.token as api_token',
                'api_tokens.expired_at as token_expired',
                'start_dates.date as start_date',
                'users.name',
                'users.email',
                'users.created_at',
                'users.updated_at'
            )
            ->where('users.email', $email)
            ->first();

        Log::info("get by email success", [
            'email' => $email
        ]);

        return $user;
    }
}
