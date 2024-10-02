<?php

namespace App\Repository;

use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TokenRepository
{
    public function create(User $user): string | null
    {
        try {
            $token = Str::random(30);

            ApiToken::create([
                'user_id' => $user->id,
                'token' => $token,
                'expired_at' => round(microtime(true) * 1000) + 60 * 5 * 1000,
                'created_at' => round(microtime(true) * 1000),
                'updated_at' => round(microtime(true) * 1000),
            ]);

            Log::info("insert api token to database success", [
                'email' => $user->email
            ]);

            return $token;
        } catch (\Throwable $th) {
            Log::error("insert api token to database failed", [
                'email' => $user->email
            ]);

            return null;
        }
    }
}
