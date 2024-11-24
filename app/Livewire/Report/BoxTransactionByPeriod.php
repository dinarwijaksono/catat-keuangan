<?php

namespace App\Livewire\Report;

use App\Livewire\Component\AlertSuccess;
use App\Livewire\Transaction\FormEditTransaction;
use App\Services\CategoryService;
use App\Services\PeriodService;
use App\Services\ReportService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BoxTransactionByPeriod extends Component
{
    protected $periodService;
    protected $reportService;
    protected $categoryService;
    protected $transactionService;

    public $listPeriod;
    public $listCategory;
    public $listTransaction;

    public $periodSelect;
    public $categorySelect;

    public function boot()
    {
        $this->periodService = App::make(PeriodService::class);
        $this->reportService = App::make(ReportService::class);
        $this->categoryService = App::make(CategoryService::class);
        $this->transactionService = App::make(TransactionService::class);

        $this->listPeriod = $this->periodService->getAll(auth()->user());
        $this->listCategory = $this->categoryService->getAll(auth()->user());
    }

    public function mount()
    {
        if ($this->listPeriod) {

            $this->listTransaction = $this->transactionService->getByPeriod(auth()->user()->id, $this->listPeriod->first()->id);

            $this->periodSelect = $this->listPeriod->first()->id;
        }
    }

    public function doRefresh()
    {
        $this->listTransaction = $this->transactionService->getByPeriod(auth()->user()->id, $this->listPeriod->first()->id);
    }

    public function getListeners()
    {
        return [
            'do-render' => 'doRefresh'
        ];
    }

    public function doSearchTransaction()
    {
        if ($this->categorySelect == 'all' || is_null($this->categorySelect)) {

            $this->listTransaction = $this->transactionService->getByPeriod(auth()->user()->id, $this->periodSelect);
        } else {
            $listTransaction = $this->transactionService->getByPeriod(auth()->user()->id, $this->periodSelect);
            $this->listTransaction = $listTransaction->where('category_code', $this->categorySelect);
        }
    }

    public function doDeleteTransaction(string $code)
    {
        try {

            $this->transactionService->delete(auth()->user(), $code);

            $this->dispatch('do-render')->self();
            $this->dispatch('alert-show', "Transaksi berhasil di hapus.")->to(AlertSuccess::class);

            Log::info("delete transaction success", [
                'user_id' => auth()->user()->id,
                'user_email' => auth()->user()->email,
                'transaction_code' => $code
            ]);
        } catch (\Throwable $th) {
            Log::error("delete transaction failed", [
                'user_id' => auth()->user()->id,
                'user_email' => auth()->user()->email,
                'transaction_code' => $code,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function doEdit(string $code)
    {
        $this->dispatch('open-box', code: $code)->to(FormEditTransaction::class);
    }

    public function render()
    {
        return view('livewire.report.box-transaction-by-period');
    }
}
