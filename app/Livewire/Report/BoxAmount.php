<?php

namespace App\Livewire\Report;

use App\Services\ReportService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BoxAmount extends Component
{
    protected $reportService;

    public $amount;

    public function boot()
    {
        Log::withContext([
            'user_id' => auth()->user()->id,
            'user_email' => auth()->user()->email,
        ]);

        $this->reportService = App::make(ReportService::class);

        $this->amount = $this->reportService->getAmount(auth()->user());
    }

    public function render()
    {
        return view('livewire.report.box-amount');
    }
}
