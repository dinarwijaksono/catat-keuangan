<?php

namespace App\Livewire\Category;

use App\Livewire\Component\AlertSuccess;
use App\Services\CategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BoxCategory extends Component
{
    public $categories;

    protected $categoryService;

    public function boot()
    {
        Log::withContext([
            'class' => BoxCategory::class,
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
        ]);

        $this->categoryService = App::make(CategoryService::class);

        $this->categories = $this->categoryService->getAll(auth()->user()->id)->sortBy('name');
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
            $this->categoryService->delete($code);

            $this->dispatch('alert-show', "Kategori berhasil di hapus.")->to(AlertSuccess::class);
            $this->dispatch('delete-category')->self();

            Log::info('do delete by code success');
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
