<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:50',
            'type' => 'required'
        ]);

        $token = ApiToken::where('token', $request->header('api-token'))->first();

        if ($validator->fails()) {
            Log::warning('POST /api/category-create failed, validasi error', [
                'user_id' => $token->user_id
            ]);

            return response()->json([
                'message' => 'Validasi error.',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!in_array($request->type, ['income', 'spending'])) {
            Log::warning('POST /api/category-create failed, validasi error format type salah', [
                'user_id' => $token->user_id
            ]);

            return response()->json([
                'message' => 'Validasi error.',
                'errors' => [
                    'type' => 'Format type salah.'
                ]
            ], 422);
        }

        Log::info('POST /api/category-create success', [
            'user_id' => $token->user_id
        ]);

        $this->categoryService->create($token->user_id, $request->name, $request->type);

        return response()->json([
            'message' => "Create category success",
        ], 201);
    }

    public function getAll(Request $request)
    {
        $token = ApiToken::where('token', $request->header('api-token'))->first();

        $categories = $this->categoryService->getAll($token->user_id);

        Log::info('GET /api/category/get-all success', [
            'user_id' => $token->user_id
        ]);

        return response()->json([
            'data' => $categories->toArray()
        ], 200);
    }

    public function delete(Request $request)
    {
        $token = ApiToken::where('token', $request->header('api-token'))->first();
    }
}
