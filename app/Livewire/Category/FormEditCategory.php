<?php

namespace App\Livewire\Category;

use App\Livewire\Component\AlertSuccess;
use App\Services\CategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormEditCategory extends Component
{
    public $code;
    public $category;
    public $categoryName;


    protected $categoryService;

    public function boot()
    {
        $this->categoryService = App::make(CategoryService::class);

        $this->category = $this->categoryService->getByCode($this->code);
    }

    public function mount()
    {
        $this->categoryName = $this->category->name;
    }

    public function getRules()
    {
        return ['categoryName' => 'required|min:4'];
    }

    public function doUpdate()
    {
        $this->validate();

        try {
            $this->categoryService->update($this->code, $this->categoryName);

            $this->dispatch('alert-show', 'Kategori berhasil di edit.')->to(AlertSuccess::class);

            Log::info('do update success');
        } catch (\Throwable $th) {
            Log::error('do update failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.category.form-edit-category');
    }
}
