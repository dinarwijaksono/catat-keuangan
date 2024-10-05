<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use App\Repository\TokenRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenMiddeware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('api-token');

        $tokenRepository = App::make(TokenRepository::class);

        $apiToken = ApiToken::where('token', $token)->first();
        if (!$apiToken) {
            Log::warning('token is wrong', [
                'token' => $token
            ]);

            return response()->json([
                'message' => 'Token salah.'
            ], 401);
        }

        if ($tokenRepository->checkExpired($token)) {
            Log::warning('token has expired', [
                'user_id' => $apiToken->user_id
            ]);

            return response()->json([
                'message' => 'Token expired.'
            ], 401);
        }

        return $next($request);
    }
}
