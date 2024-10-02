<?php

namespace App\Repository;

use App\Models\StartDate;
use App\Models\User;
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
}
