<?php

namespace App\Livewire\Transaction;

use App\Domains\TransactionDomain;
use App\Livewire\Component\AlertSuccess;
use App\Services\CategoryService;
use App\Services\PeriodService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormCreateTransaction extends Component
{
    public $date;
    public $type;
    public $category;
    public $total;
    public $description;

    public $isHidden = true;

    public $showTotal;

    public $listCategory;
    public $listSelectCategory;

    protected $categoryService;
    protected $periodService;
    protected $transactionService;

    public function boot()
    {
        Log::withContext([
            'class' => FormCreateTransaction::class,
            'user_id' => auth()->user()->id,
            'user_email' => auth()->user()->email
        ]);

        $this->categoryService = App::make(CategoryService::class);
        $this->periodService = App::make(PeriodService::class);
        $this->transactionService = App::make(TransactionService::class);

        $this->listCategory = $this->categoryService->getAll(auth()->user()->id);
    }

    public function mount()
    {
        $this->date = date('Y-m-d', $this->date);

        $this->type = 'spending';

        $this->listSelectCategory = $this->listCategory->where('type', 'spending');

        if ($this->listSelectCategory->isEmpty()) {
            $this->type = 'income';
            $this->listSelectCategory = $this->listCategory->where('type', 'income');
        }
    }

    public function getRules()
    {
        return [
            'date' => 'required',
            'type' => 'required',
            'category' => 'required',
            'total' => 'required|numeric',
            'description' => 'required'
        ];
    }

    public function getListeners()
    {
        return [
            'open-box' => 'doShowBox'
        ];
    }

    public function doSetType(string $type)
    {
        $this->type = $type;

        $this->listSelectCategory = $this->listCategory->where('type', $type);
    }

    public function setTotal()
    {
        if (is_numeric($this->total)) {
            $this->showTotal  = $this->total;
        } else {
            $this->showTotal = 0;
        }
    }

    public function doShowBox()
    {
        $this->isHidden = false;
    }

    public function doHideBox()
    {
        $this->isHidden = true;
    }

    public function doCreateTransaction()
    {
        $this->dispatch('alert-hide', "")->to(AlertSuccess::class);

        $this->validate();

        try {
            DB::beginTransaction();

            $month = date('n', strtotime($this->date));
            $year = date('Y', strtotime($this->date));
            $user = auth()->user();

            if ($this->periodService->checkIsEmpty($user, $month, $year)) {
                $periodId = $this->periodService->createGetId($user, $month, $year);
            } else {
                $period = $this->periodService->getByMonthYear($user, $month, $year);
                $periodId = $period->id;
            }

            $transactionDomain = new TransactionDomain();
            $transactionDomain->userId = $user->id;
            $transactionDomain->categoryId = $this->category;
            $transactionDomain->periodId = $periodId;
            $transactionDomain->date = strtotime($this->date);
            $transactionDomain->description = $this->description;
            $transactionDomain->income = $this->type == 'income' ? $this->total : 0;
            $transactionDomain->spending = $this->type == 'spending' ? $this->total : 0;

            $this->transactionService->create($transactionDomain);

            $this->date = date('Y-m-d');
            $this->type = 'spending';
            $this->category = $this->listSelectCategory->first()->id;
            $this->total = '';
            $this->description = '';
            $this->showTotal = 0;

            Log::info('do create transaction success');
            DB::commit();

            $this->dispatch('alert-show', "Transaksi berhasil di buat.")->to(AlertSuccess::class);
            $this->dispatch('create-transaction')->to(BoxTransactionInToday::class);
            $this->dispatch('do-render')->to(TransactionInPeriod::class);

            $this->isHidden = true;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('do create transaction failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.transaction.form-create-transaction');
    }
}
