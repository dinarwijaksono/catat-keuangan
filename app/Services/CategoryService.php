<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;
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

    // create
    public function create(int $userId, string $name, string $type): void
    {
        self::boot();

        try {
            Category::insert([
                'user_id' => $userId,
                'code' => 'C' . random_int(1, 999999999),
                'name' => strtolower($name),
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

    // read
    public function getByCode(string $categoryCode): object
    {
        self::boot();

        try {
            $category = Category::select('id', 'user_id', 'code', 'name', 'type', 'created_at', 'updated_at')
                ->where('code', $categoryCode)
                ->first();

            Log::info('Get category by code success');

            return $category;
        } catch (\Throwable $th) {
            Log::error('Get category by code failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getAll(int $userId): Collection
    {
        self::boot();

        try {

            $category = Category::select('user_id', 'code', 'name', 'type', 'created_at', 'updated_at')
                ->where('user_id', $userId)
                ->get();

            Log::info('get all category success');

            return $category;
        } catch (\Throwable $th) {
            Log::error('get all category failed', [
                'message' => $th->getMessage()
            ]);

            return collect([]);
        }
    }

    // update
    public function update(string $categoryCode, string $categoryName): void
    {
        self::boot();

        try {
            Category::where('code', $categoryCode)
                ->update([
                    'name' => strtolower(trim($categoryName)),
                    'updated_at' => round(microtime(true) * 1000),
                ]);

            Log::info('Update category success');
        } catch (\Throwable $th) {
            Log::error('Update category failed', [
                'message' => $th->getMessage()
            ]);
        }
    }
}
