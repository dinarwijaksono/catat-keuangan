<?php

namespace App\Livewire\GenerateData;

use App\Services\ImportService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class FormImport extends Component
{
    private $importService;

    public function boot()
    {
        Log::withContext([
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
        ]);

        $this->importService = App::make(ImportService::class);
    }

    public function doDownloadFormat()
    {
        try {
            $this->importService->makeFormatFile();

            Log::info('do download file success');

            return Storage::download('Format/format-import-data.csv');
        } catch (\Throwable $th) {
            Log::error('do download file failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.generate-data.form-import');
    }
}
