<?php

namespace App\Livewire\Transaction;

use App\Domains\TransactionDomain;
use App\Livewire\Component\AlertSuccess;
use App\Livewire\Report\BoxTransactionByPeriod;
use App\Services\CategoryService;
use App\Services\PeriodService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormEditTransaction extends Component
{
    public $code;

    public $date;
    public $type;
    public $category;
    public $total;
    public $description;

    public $isHidden = true;

    public $listCategory;
    public $listSelectCategory;

    public $showTotal;

    public $getTransaction;

    protected $periodService;
    protected $categoryService;
    protected $transactionService;

    public function boot()
    {
        $this->periodService = App::make(PeriodService::class);
        $this->categoryService = App::make(CategoryService::class);
        $this->transactionService = App::make(TransactionService::class);

        $this->listCategory = $this->categoryService->getAll(auth()->user());

        if (is_string($this->code)) {
            $this->getTransaction = $this->transactionService->getByCode(auth()->user(), $this->code);
        }
    }

    public function mount()
    {
        if (is_string($this->code)) {

            $this->date = date('Y-m-d', $this->getTransaction->date);
            $this->type = $this->getTransaction->income == 0 ? 'spending' : 'income';
            $this->total = $this->type == 'income' ? $this->getTransaction->income : $this->getTransaction->spending;
            $this->description = $this->getTransaction->description;
            $this->category = $this->getTransaction->category_id;

            $this->showTotal = $this->total;
        }

        $this->listSelectCategory = $this->listCategory->where('type', $this->type);
    }

    public function getRules()
    {
        return [
            'date' => 'required',
            'type' => 'required',
            'category' => 'required',
            'total' => 'required',
            'description' => 'required'
        ];
    }

    public function getListeners()
    {
        return [
            'open-box' => 'doShowBox'
        ];
    }

    public function setTotal()
    {
        $this->showTotal = is_numeric($this->total) ? $this->total : 0;
    }

    public function doSetType(string $type)
    {
        $this->type = $type;
    }

    public function doEdit()
    {
        try {
            DB::beginTransaction();

            $date = strtotime($this->date);

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
            $transactionDomain->date = $date;
            $transactionDomain->code = $this->code;
            $transactionDomain->periodId = $periodId;
            $transactionDomain->categoryId = $this->category;
            $transactionDomain->description = $this->description;
            $transactionDomain->income = $this->type == 'income' ? $this->total : 0;
            $transactionDomain->spending = $this->type == 'spending' ? $this->total : 0;

            $this->transactionService->update(auth()->user(), $transactionDomain);

            Log::info("do edit transaction success");
            DB::commit();

            $this->isHidden = true;
            $this->dispatch('alert-show', "Transaksi berhasil di edit.")->to(AlertSuccess::class);
            $this->dispatch('edit-transaction')->to(BoxTransactionInToday::class);
            $this->dispatch('do-render')->to(TransactionInPeriod::class);

            $this->dispatch('do-render')->to(BoxTransactionByPeriod::class);
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('do edit transaction failed', [
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function doShowBox($code)
    {
        $this->code = $code;
        $this->listCategory = $this->categoryService->getAll(auth()->user());

        $getTransaction = $this->transactionService->getByCode(auth()->user(), $this->code);

        $this->date = date('Y-m-d', $getTransaction->date);
        $this->type = $getTransaction->income == 0 ? 'spending' : 'income';
        $this->total = $this->type == 'income' ? $getTransaction->income : $getTransaction->spending;
        $this->description = $getTransaction->description;

        $this->listSelectCategory = $this->listCategory->where('type', $this->type);

        $this->category = $getTransaction->category_id;

        $this->showTotal = $this->total;

        $this->isHidden = false;
    }

    public function doHideBox()
    {
        $this->isHidden = true;
    }

    public function render()
    {
        return view('livewire.transaction.form-edit-transaction');
    }
}
