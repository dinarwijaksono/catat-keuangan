<?php

namespace App\Services;

use App\Exceptions\RegisterException;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterService
{
    public $userRepository;
    public $tokenRepository;

    public function __construct(UserRepository $userRepository, TokenRepository $tokenRepository)
    {
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
    }

    public function register(string $name, string $email, string $password): Collection | null
    {
        try {
            DB::beginTransaction();

            if ($this->userRepository->checkByEmail($email)) {
                throw new RegisterException("Email not unique.");
            }

            $user = $this->userRepository->create($name, $email, $password);
            $this->userRepository->setStartDate($user, 1);
            $token = $this->tokenRepository->create($email);

            DB::commit();

            Log::info('register success', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return collect([
                'user_id' => $user->id,
                'email' => $user->email,
                'api_token' => $token,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('register failed', [
                'email' => $email,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }
}
