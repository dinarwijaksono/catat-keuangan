<?php

namespace App\Livewire\Category;

use App\Livewire\Component\Alert;
use App\Livewire\Component\AlertDanger;
use App\Livewire\Component\AlertSuccess;
use App\Services\CategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BoxCategory extends Component
{
    public $categories;

    protected $categoryService;

    public $user;

    public $categoryName;

    public function boot()
    {
        Log::withContext([
            'user_id' => auth()->user()->id,
            'user_email' => auth()->user()->email,
        ]);

        $this->user = auth()->user();

        $this->categoryService = App::make(CategoryService::class);

        $this->categories = $this->categoryService->getAll($this->user)
            ->sortBy('name');
    }

    public function getListeners()
    {
        return [
            'create-category' => 'render',
            'delete-category' => 'render'
        ];
    }

        public function doDelete(string $code)
    {
        try {
            $result = $this->categoryService->delete(auth()->user(), $code);

            if ($result) {
                $this->dispatch('alert-show', "Kategori berhasil di hapus.")->to(AlertSuccess::class);
                $this->dispatch('delete-category')->self();

                Log::info('do delete by code success');
            } else {
                $this->dispatch('alert-show', "Kategori gagal di hapus, kategori masih dipakai pada transaksi.")
                    ->to(AlertDanger::class);
            }
        } catch (\Throwable $th) {
            Log::error('do delete by code failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function doOpenFormCreateCategory(){
        $this->dispatch('open-box')->to(FormCreateCategory::class);
    }

    public function render()
    {
        return view('livewire.category.box-category');
    }
}
