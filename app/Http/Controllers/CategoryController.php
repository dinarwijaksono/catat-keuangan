<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $user;
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->user = auth()->user();
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('category.index');
    }

    public function edit(string $code)
    {
        $data['categoryCode'] = $code;

        return view('category.edit', $data);
    }

    public function detail(string $categoryCode)
    {
        $category = $this->categoryService->getByCode($this->user, $categoryCode);

        $data['categoryCode'] = $categoryCode;
        $data['category'] = $category;

        return view('category.detail', $data);
    }
}
