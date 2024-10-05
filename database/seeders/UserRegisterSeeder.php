<?php

namespace Database\Seeders;

use App\Models\ApiToken;
use App\Models\StartDate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => "User Test",
            'email' => "example@gmail.com",
            'password' => Hash::make('rahasia'),
        ]);

        ApiToken::create([
            'user_id' => $user->id,
            'token' => Str::random(30),
            'expired_at' => round(microtime(true) * 1000) + 60 * 60 * 5 * 1000,
            'created_at' => round(microtime(true) * 1000),
            'updated_at' => round(microtime(true) * 1000),
        ]);

        StartDate::insert([
            'user_id' => $user->id,
            'date' => 10,
            'created_at' => round(microtime(true) * 1000),
            'updated_at' => round(microtime(true) * 1000),
        ]);
    }
}
