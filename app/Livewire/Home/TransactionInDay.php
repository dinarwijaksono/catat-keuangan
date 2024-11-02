<?php

namespace App\Livewire\Home;

use App\Livewire\Component\AlertSuccess;
use App\Livewire\Transaction\FormCreateTransaction;
use App\Livewire\Transaction\FormEditTransaction;
use App\Services\TransactionService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TransactionInDay extends Component
{
    public $date;
    public $transaction;

    protected $transactionService;

    public function boot()
    {
        Log::withContext([
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
        ]);

        $this->transactionService = App::make(TransactionService::class);
        $this->transaction = $this->transactionService->getByDate(auth()->user(), $this->date);
    }

    public function getListeners()
    {
        return [
            'delete-success' => 'render',
            'create-transaction' => 'render',
            'edit-transaction' => 'render'
        ];
    }

    public function doCreateTransaction()
    {
        $this->dispatch('open-box')->to(FormCreateTransaction::class);
    }

    public function doEditTransaction(string $code)
    {
        $this->dispatch('open-box', $code)->to(FormEditTransaction::class);
    }

    public function doDelete(string $transactionCode)
    {
        $this->dispatch('alert-hide')->to(AlertSuccess::class);

        try {
            $this->transactionService->delete(auth()->user(), $transactionCode);

            $this->dispatch('delete-success')->self();
            $this->dispatch('alert-show', "Transaksi berhasil di hapus.")->to(AlertSuccess::class);

            Log::info('do delete transaction success');
        } catch (\Throwable $th) {
            Log::error('do delete transaction failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.home.transaction-in-day');
    }
}
