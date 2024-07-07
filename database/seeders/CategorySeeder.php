<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::select('id')->first();

        $type = ['income', 'spending'];

        Category::insert([
            'user_id' => $user->id,
            'code' => 'C' . random_int(1, 999999999),
            'name' => 'category - ' . random_int(1, 1000),
            'type' => $type[random_int(0, 1)],
            'created_at' => round(microtime(true) * 1000),
            'updated_at' => round(microtime(true) * 1000),
        ]);
    }
}
