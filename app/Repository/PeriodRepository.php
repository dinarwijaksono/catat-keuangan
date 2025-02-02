<?php

namespace App\Repository;

use App\Models\Period;

class PeriodRepository
{
    public function create(int $userId, int $date): Period
    {
        return Period::create([
            'user_id' => $userId,
            'period_date' => $date,
            'period_name' => date('F Y', $date),
            'is_close' => false,
            'created_at' => now()->timestamp * 1000,
            'updated_at' => now()->timestamp * 1000,
        ]);
    }

    public function findOrCreate($userId, $date): Period
    {
        $period = Period::where('user_id', $userId)
            ->where('period_date', $date)
            ->first();

        return $period ?? $this->create($userId, $date);
    }
}
