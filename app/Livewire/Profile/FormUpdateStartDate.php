<?php

namespace App\Livewire\Profile;

use App\Services\UserService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormUpdateStartDate extends Component
{
    public $startDate;
    public $date;

    protected $userService;

    public function boot()
    {
        Log::withContext([
            'class' => FormUpdateStartDate::class,
            'user_id' => auth()->user()->id,
            'user_email' => auth()->user()->name
        ]);

        $this->userService = App::make(UserService::class);

        $this->startDate = $this->userService->getStartDate(auth()->user()->id);
    }

    public function mount()
    {
        $this->date = $this->startDate->date;
    }

    public function getRules()
    {
        return [
            'date' => 'required|numeric'
        ];
    }

    public function doUpdateStartDate()
    {
        $this->validate();

        try {
            $this->userService->updateStartDate(auth()->user()->id, $this->date);

            Log::info('do update start date success');

            return redirect('/profile');
        } catch (\Throwable $th) {
            Log::error('do update start date failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.profile.form-update-start-date');
    }
}
