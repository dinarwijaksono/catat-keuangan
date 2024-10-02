<?php

namespace Tests\Feature\Repository;

use App\Models\User;
use App\Repository\UserRepository;
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
}
