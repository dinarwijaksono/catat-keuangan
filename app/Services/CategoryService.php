<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    public function boot()
    {
        Log::withContext([
            'class' => CategoryService::class,
            'user_id' => auth()->user()->id,
            'user_email' => auth()->user()->email,
        ]);
    }

    public function create(int $userId, string $name, string $type): void
    {
        self::boot();

        try {
            Category::insert([
                'user_id' => $userId,
                'code' => 'C' . random_int(1, 999999999),
                'name' => $name,
                'type' => $type,
                'created_at' => round(microtime(true) * 1000),
                'updated_at' => round(microtime(true) * 1000),
            ]);

            Log::info('create category success');
        } catch (\Throwable $th) {
            Log::error('create category failed', [
                'message' => $th->getMessage()
            ]);
        }
    }
}
