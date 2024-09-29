<?php

namespace App\Livewire\Report;

use App\Services\ReportService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BoxTotalCategoryByPeriod extends Component
{
    protected $reportService;

    public $transaction;

    public function boot()
    {
        Log::withContext([
            'user_id' => auth()->user()->id,
            'user_email' => auth()->user()->email,
        ]);

        $this->reportService = App::make(ReportService::class);

        $period = DB::table('transactions')
            ->select('period_id')
            ->where('user_id', auth()->user()->id)
            ->orderByDesc('date')
            ->first();

        if ($period == null) {
            $this->transaction = null;
        } else {
            $this->transaction = $this->reportService->getTotalCategoryByPeriod(auth()->user(), $period->period_id);
        }
    }

    public function render()
    {
        return view('livewire.report.box-total-category-by-period');
    }
}
