<?php

namespace Tests\Feature\Services;

use App\Services\ImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImportServiceTest extends TestCase
{
    private $importService;

    public function setUp(): void
    {
        parent::setUp();

        $this->importService = $this->app->make(ImportService::class);
    }

    public function test_make_format_file(): void
    {
        $this->importService->makeFormatFile();

        $file = Storage::disk('local');

        $this->assertTrue($file->exists('Format/format-import-data.csv'));
    }
}
