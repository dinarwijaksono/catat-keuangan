<?php

namespace App\Services;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    public function boot($user): void
    {
        Log::withContext([
            'class' => CategoryService::class,
            'user_id' => $user->id,
            'user_email' => $user->email,
        ]);
    }

    // create
    public function create(User $user, string $name, string $type): void
    {
        self::boot($user);

        try {
            Category::insert([
                'user_id' => $user->id,
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
    public function getByCode(User $user, string $categoryCode): object
    {
        self::boot($user);

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

    public function getAll(User $user): Collection
    {
        self::boot($user);

        try {

            $category = Category::select('id', 'user_id', 'code', 'name', 'type', 'created_at', 'updated_at')
                ->where('user_id', $user->id)
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
    public function update(User $user, string $categoryCode, string $categoryName): void
    {
        self::boot($user);

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


    // delete
    public function delete(User $user, string $categoryCode): void
    {
        self::boot($user);

        try {
            Category::where('code', $categoryCode)
                ->delete();

            Log::info('delete category success');
        } catch (\Throwable $th) {
            Log::error('delete category failed');
        }
    }
}
