<?php

namespace Tests\Feature\Services;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Services\CategoryService;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    public $user;

    public $categoryService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();

        $this->categoryService = $this->app->make(CategoryService::class);
    }

    public function test_create(): void
    {
        $name = 'Example name';
        $type = 'spending';

        $this->categoryService->create($this->user->id, $name, $type);

        $this->assertDatabaseHas('categories', [
            'user_id' => $this->user->id,
            'name' => $name,
            'type' => $type
        ]);
    }

    public function test_create_get_id()
    {
        $name = 'Example name';
        $type = 'spending';

        $response = $this->categoryService->createGetId($this->user->id, $name, $type);

        $this->assertIsInt($response);
        $this->assertDatabaseHas('categories', [
            'id' => $response,
            'name' => $name,
            'type' => $type
        ]);
    }

    public function test_check_is_exist_return_true()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);

        $category = Category::select('*')->first();

        $response = $this->categoryService->checkIsExist($this->user, $category->name, $category->type);

        $this->assertTrue($response);
    }

    public function test_check_is_exist_return_false()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);

        $category = Category::select('*')->first();

        $response = $this->categoryService->checkIsExist($this->user, "category is empty", $category->type);

        $this->assertFalse($response);
    }

    public function test_get_by_name_and_type()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);

        $category = Category::select('*')->first();

        $response = $this->categoryService->getByNameAndType($this->user, $category->name, $category->type);

        $this->assertEquals($category->id, $response->id);
    }

    public function test_get_by_code()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);

        $category = Category::select('*')->first();

        $response = $this->categoryService->getByCode($this->user, $category->code);

        $this->assertEquals($category->name, $response->name);
        $this->assertEquals($category->type, $response->type);
    }

    public function test_get_all()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);

        $response = $this->categoryService->getAll($this->user->id);

        $this->assertIsObject($response);
        $this->assertEquals($response->count(), 3);
    }


    public function test_update()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::select('*')->first();
        $name = 'example new name';

        $this->categoryService->update($this->user, $category->code, $name);

        $this->assertDatabaseHas('categories', [
            'user_id' => $this->user->id,
            'code' => $category->code,
            'name' => $name
        ]);
    }

    public function test_delete_category_used()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);
        $this->seed(TransactionSeeder::class);

        $transaction = Transaction::select('*')->first();

        $category = Category::select('*')
            ->where('id', $transaction->category_id)
            ->first();

        $response = $this->categoryService->delete($this->user->id, $category->code);

        $this->assertFalse(($response['status']));
        $this->assertEquals($response['message'], "Kategorin digunakan pada transaksi.");
        $this->assertDatabaseHas('categories', [
            'code' => $category->code
        ]);
    }

    public function test_delete_success()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);

        $category = Category::select('*')->first();

        $response = $this->categoryService->delete($this->user->id, $category->code);

        $this->assertTrue($response['status']);
        $this->assertDatabaseMissing('categories', [
            'code' => $category->code
        ]);
    }
}
