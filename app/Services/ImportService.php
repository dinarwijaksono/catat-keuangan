<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportService
{
    public function makeFormatFile(): void
    {
        try {
            $file = Storage::disk('local');
            $file->makeDirectory('Format');

            $content = ";No;Tanggal;Bulan;Tahun;Kategori;Deskirpsi;Type (income/spending);value;";

            $file->put('Format/format-import-data.csv', $content);

            Log::info('make format file success');
        } catch (\Throwable $th) {
            Log::error('make format file failed', [
                'message' => $th->getMessage()
            ]);
        }
    }
}
