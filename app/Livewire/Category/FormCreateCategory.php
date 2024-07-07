<?php

namespace App\Livewire\Category;

use App\Livewire\Component\AlertSuccess;
use App\Services\CategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormCreateCategory extends Component
{
    public $categoryName;
    public $type;

    protected $categoryService;

    public function boot()
    {
        Log::withContext([
            'class' => FormCreateCategory::class,
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
        ]);

        $this->categoryService = App::make(CategoryService::class);
    }

    public function getRules()
    {
        return [
            'categoryName' => 'required|min:3|max:50',
            'type' => 'required'
        ];
    }

    public function doSetType(string $type)
    {
        $this->type = $type;
    }

    public function doCreateCategory()
    {
        $this->validate();

        $this->dispatch('alert-hide')->to(AlertSuccess::class);

        try {

            $this->categoryService->create(auth()->user()->id, $this->categoryName, $this->type);

            $this->categoryName = '';
            $this->type = '';

            $this->dispatch('alert-show', message: "Kategori berhasil disimpan.")->to(AlertSuccess::class);

            Log::info('do create category success');
        } catch (\Throwable $th) {
            Log::error('do create category failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.category.form-create-category');
    }
}
