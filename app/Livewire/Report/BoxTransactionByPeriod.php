<?php

namespace App\Livewire\Report;

use App\Services\CategoryService;
use App\Services\PeriodService;
use App\Services\ReportService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\App;
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

    public function doSearchTransaction()
    {
        if ($this->categorySelect == 'all' || is_null($this->categorySelect)) {

            $this->listTransaction = $this->transactionService->getByPeriod(auth()->user()->id, $this->periodSelect);
        } else {
            $listTransaction = $this->transactionService->getByPeriod(auth()->user()->id, $this->periodSelect);
            $this->listTransaction = $listTransaction->where('category_code', $this->categorySelect);
        }
    }

    public function render()
    {
        return view('livewire.report.box-transaction-by-period');
    }
}
