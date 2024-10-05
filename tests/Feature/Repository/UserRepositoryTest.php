<?php

namespace Tests\Feature\Repository;

use App\Models\User;
use App\Repository\UserRepository;
use Database\Seeders\UserRegisterSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    public $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->app->make(UserRepository::class);
    }

    public function test_create_success(): void
    {
        $name = 'example';
        $email = 'example@gmail.com';
        $password = 'rahasia';

        $response = $this->userRepository->create($name, $email, $password);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
        ]);

        $this->assertEquals($response->name, $name);
        $this->assertEquals($response->email, $email);
    }

    public function test_set_start_date()
    {
        $this->seed(UserSeeder::class);

        $user = User::select('*')->first();

        $this->userRepository->setStartDate($user, 10);

        $this->assertDatabaseHas('start_dates', [
            'user_id' => $user->id,
            'date' => 10
        ]);
    }

    public function test_check_by_email_true()
    {
        $this->seed(UserSeeder::class);
        $user = User::select('*')->first();

        $response = $this->userRepository->checkByEmail($user->email);

        $this->assertTrue($response);
    }

    public function test_check_by_email_false()
    {
        $response = $this->userRepository->checkByEmail("example@gmail.com");

        $this->assertFalse($response);
    }

    public function test_check_password_true()
    {
        $this->seed(UserRegisterSeeder::class);
        $user = User::select('*')->first();

        $response = $this->userRepository->checkPassword($user->email, 'rahasia');

        $this->assertTrue($response);
    }

    public function test_check_password_false()
    {
        $this->seed(UserRegisterSeeder::class);
        $user = User::select('*')->first();

        $response = $this->userRepository->checkPassword($user->email, 'salah');

        $this->assertFalse($response);
    }

    public function test_get_by_email()
    {
        $this->seed(UserRegisterSeeder::class);
        $user = User::select('*')->first();

        $response = $this->userRepository->getByEmail($user->email);

        $this->assertObjectHasProperty('api_token', $response);
        $this->assertObjectHasProperty('token_expired', $response);
        $this->assertObjectHasProperty('start_date', $response);
        $this->assertObjectHasProperty('name', $response);
        $this->assertObjectHasProperty('email', $response);
    }
}
