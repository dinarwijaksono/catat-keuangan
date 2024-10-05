<?php

namespace App\Repository;

use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TokenRepository
{
    // create
    public function create(string $email): string | null
    {
        try {
            $token = Str::random(30);

            $user = User::select('id')->where('email', $email)->first();

            ApiToken::create([
                'user_id' => $user->id,
                'token' => $token,
                'expired_at' => round(microtime(true) * 1000) + 3 * 24 * 60 * 60 * 1000,
                'created_at' => round(microtime(true) * 1000),
                'updated_at' => round(microtime(true) * 1000),
            ]);

            Log::info("insert api token to database success", [
                'email' => $email
            ]);

            return $token;
        } catch (\Throwable $th) {
            Log::error("insert api token to database failed", [
                'email' => $email,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    // read
    public function checkExpired(string $token): bool
    {
        $t = ApiToken::select('expired_at')
            ->where('token', $token)
            ->first();

        Log::info('check token expired success', [
            'token' => $token
        ]);

        return $t->expired_at < (microtime(true) * 1000);
    }
}
