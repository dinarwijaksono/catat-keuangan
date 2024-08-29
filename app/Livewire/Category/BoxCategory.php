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

    public $type;
    public $categoryName;

    public function mount()
    {
        $this->type = 'spending';

        $this->categories = $this->categoryService->getAll($this->user)
            ->where('type', 'spending')
            ->sortBy('name');
    }

    public function boot()
    {
        Log::withContext([
            'user_id' => auth()->user()->id,
            'user_email' => auth()->user()->email,
        ]);

        $this->user = auth()->user();

        $this->categoryService = App::make(CategoryService::class);
    }

    public function getListeners()
    {
        return [
            'create-category' => 'render',
            'delete-category' => 'render'
        ];
    }

    public function doCreateCategory()
    {
        $this->categoryService->create($this->user, $this->categoryName, $this->type);

        $this->dispatch('alert-show', message: "Kategori berhasil disimpan.")->to(AlertSuccess::class);

        $this->categories = $this->categoryService->getAll($this->user)
            ->where('type', $this->type)
            ->sortBy('name');

        $this->categoryName = '';
    }

    public function toSetType($type)
    {
        $this->type = $type;

        $this->categories = $this->categoryService->getAll($this->user)
            ->where('type', $type)
            ->sortBy('name');
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

    public function render()
    {
        return view('livewire.category.box-category');
    }
}
