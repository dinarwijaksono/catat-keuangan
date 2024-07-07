<?php

namespace Tests\Feature\Livewire\Category;

use App\Livewire\Category\FormEditCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormEditCategoryTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(FormEditCategory::class)
            ->assertStatus(200);
    }
}
