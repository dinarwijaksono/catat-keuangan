<?php

namespace App\Services;

use App\Exceptions\LoginException;
use App\Models\User;
use Exception;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class LoginService
{
    public $userRepository;
    public $tokenRepository;

    public function __construct(UserRepository $userRepository, TokenRepository $tokenRepository)
    {
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
    }

    public function login(string $email, string $password): object | null
    {
        try {
            if (!$this->userRepository->checkByEmail($email)) {
                throw new LoginException("Login failed, email is wrong.");
            }

            if (!$this->userRepository->checkPassword($email, $password)) {
                throw new LoginException("Login failed password is wrong");
            }

            $this->tokenRepository->create($email);

            $user = $this->userRepository->getByEmail($email);

            Log::info('login success', [
                'email' => $email
            ]);

            return $user;
        } catch (\Throwable $th) {
            Log::error('login failed', [
                'email' => $email,
                'message' => $th->getMessage(),
            ]);

            return null;
        }
    }
}
