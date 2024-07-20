<?php

namespace Tests\Feature\Livewire\GenerateData;

use App\Livewire\GenerateData\FormImport;
use App\Models\User;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class FormImportTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);
        $this->user = User::select('*')->first();
        $this->actingAs($this->user);
    }

    public function test_renders_successfully()
    {
        Livewire::test(FormImport::class)
            ->assertStatus(200);
    }

    public function test_do_download_format()
    {
        Livewire::test(FormImport::class)
            ->call('doDownloadFormat');

        $this->assertTrue(Storage::disk('local')->exists('Format/format-import-data.csv'));
    }
}
