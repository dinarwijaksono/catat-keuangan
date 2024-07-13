<?php

namespace App\Domains;

class TransactionDomain
{
    public int $userId;
    public int $categoryId;
    public int $periodId;
    public string $code;
    public int $date;
    public string $description;
    public int $income;
    public int $spending;
}
