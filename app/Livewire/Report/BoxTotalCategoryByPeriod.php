<?php

namespace App\Livewire\Report;

use App\Services\PeriodService;
use App\Services\ReportService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BoxTotalCategoryByPeriod extends Component
{
    protected $periodService;
    protected $reportService;

    public $listPeriod;
    public $periodSelect;
    public $transaction;

    public function boot()
    {
        Log::withContext([
            'user_id' => auth()->user()->id,
            'user_email' => auth()->user()->email,
        ]);

        $this->periodService = App::make(PeriodService::class);
        $this->reportService = App::make(ReportService::class);

        $this->listPeriod = $this->periodService->getAll(auth()->user());
    }

    public function mount()
    {
        if ($this->listPeriod == null) {
            $this->transaction = null;
        } else {
            $this->transaction = $this->reportService->getTotalCategoryByPeriod(auth()->user(), $this->listPeriod->first()->id);
        }
    }

    public function doSelectPeriod()
    {
        $this->transaction = $this->reportService->getTotalCategoryByPeriod(auth()->user(), $this->periodSelect);
    }

    public function render()
    {
        return view('livewire.report.box-total-category-by-period');
    }
}
