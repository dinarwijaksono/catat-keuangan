<?php

namespace Database\Seeders;

use App\Models\StartDate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UserRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => "User Test",
            'email' => "test@gmail.com",
            'password' => Hash::make('rahasia'),
        ]);

        StartDate::insert([
            'user_id' => $user->id,
            'date' => 10,
            'created_at' => round(microtime(true) * 1000),
            'updated_at' => round(microtime(true) * 1000),
        ]);
    }
}
