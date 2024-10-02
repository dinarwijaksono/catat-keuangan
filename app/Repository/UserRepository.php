<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository
{
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
}
