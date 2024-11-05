<?php

namespace App\Livewire\Transaction;

use App\Services\TransactionService;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class TransactionInPeriod extends Component
{
    protected $transactionService;

    public $transactionRecent;

    public function boot()
    {
        $this->transactionService = App::make(TransactionService::class);

        $this->transactionRecent = $this->transactionService->getRecent(auth()->user());
    }

    public function render()
    {
        return view('livewire.transaction.transaction-in-period');
    }
}
