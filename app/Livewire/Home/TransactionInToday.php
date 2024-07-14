<?php

namespace App\Livewire\Home;

use App\Services\TransactionService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TransactionInToday extends Component
{
    public $transactionToday;

    protected $transactionService;

    public function boot()
    {
        Log::withContext([
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
        ]);

        $this->transactionService = App::make(TransactionService::class);
        $this->transactionToday = $this->transactionService->getByDate(auth()->user(), time());
    }

    public function render()
    {
        return view('livewire.home.transaction-in-today');
    }
}
