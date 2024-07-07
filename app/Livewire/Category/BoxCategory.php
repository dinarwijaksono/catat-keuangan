<?php

namespace App\Livewire\Category;

use App\Services\CategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BoxCategory extends Component
{
    public $categories;

    public function boot()
    {
        Log::withContext([
            'class' => BoxCategory::class,
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
        ]);

        $categoryService = App::make(CategoryService::class);

        $this->categories = $categoryService->getAll(auth()->user()->id)->sortBy('name');
    }

    public function getListeners()
    {
        return [
            'create-category' => 'render'
        ];
    }

    public function render()
    {
        return view('livewire.category.box-category');
    }
}
