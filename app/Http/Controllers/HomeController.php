<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $data['transactionRecent'] = $this->transactionService->getRecent(auth()->user());

        return view('Home.index', $data);
    }
}
