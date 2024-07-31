<?php

namespace App\Livewire\Category;

use App\Services\CategoryService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class BoxTransactionByCategory extends Component
{
    protected $categoryService;
    protected $transactionService;

    public $categoryCode;

    public $user;
    public $category;
    public $transaction;

    public $showTransaction;
    public $totalTransaction;
    public $curentPage;

    public function boot()
    {
        $this->transactionService = App::make(TransactionService::class);
        $this->categoryService = App::make(CategoryService::class);

        $this->user = auth()->user();

        $this->category = $this->categoryService->getByCode($this->user, $this->categoryCode);
        $this->transaction = $this->transactionService
            ->getByCategory($this->user, $this->category->id);

        $this->totalTransaction = $this->transaction->count();
    }

    public function mount()
    {
        $this->curentPage = 1;
        $this->showTransaction = $this->transaction->skip($this->curentPage * 20 - 20)->take(20);
    }

    public function doNextPage()
    {
        $total = ceil($this->totalTransaction / 20);

        if ($this->curentPage >= $total) {
            $this->curentPage = $total;
        } else {
            $this->curentPage += 1;
        }

        $this->showTransaction = $this->transaction->skip($this->curentPage * 20 - 20)->take(20);
    }

    public function doPrevPage()
    {
        if ($this->curentPage <= 1) {
            $this->curentPage = 1;
        } else {
            $this->curentPage -= 1;
        }

        $this->showTransaction = $this->transaction->skip($this->curentPage * 20 - 20)->take(20);
    }

    public function render()
    {
        return view('livewire.category.box-transaction-by-category');
    }
}
