<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create(int $date)
    {
        $data['date'] = $date;

        return view('Transaction.create-transaction', $data);
    }

    public function edit(string $code)
    {
        $data['transaction_code'] = $code;

        return view('Transaction.edit-transaction', $data);
    }
}
