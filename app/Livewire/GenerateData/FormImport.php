<?php

namespace App\Livewire\GenerateData;

use App\Domains\TransactionDomain;
use App\Services\CategoryService;
use App\Services\ImportService;
use App\Services\PeriodService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class FormImport extends Component
{
    use WithFileUploads;

    public $file;

    private $periodService;
    private $categoryService;
    private $importService;
    private $transactionService;

    public function boot()
    {
        Log::withContext([
            'user_id' => auth()->user()->id,
            'user_email' => auth()->user()->email,
        ]);

        $this->periodService = App::make(PeriodService::class);
        $this->importService = App::make(ImportService::class);
        $this->categoryService = App::make(CategoryService::class);
        $this->transactionService = App::make(TransactionService::class);
    }

    public function getRules()
    {
        return ['file' => 'required'];
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

    public function doImport()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $data = explode(PHP_EOL, $this->file->getContent());

            $detail = [];

            for ($i = 1; $i < count($data); $i++) {

                if (trim($data[$i]) !== "") {
                    $k = explode(",", $data[$i]);
                    $detail[] = $k;
                }
            }

            foreach ($detail as $d) {

                $user = auth()->user();

                // create period
                if ($this->periodService->checkIsEmpty($user, $d[2], $d[3])) {
                    $periodId = $this->periodService->createGetId($user, $d[2], $d[3]);
                } else {
                    $periodId = $this->periodService->getByMonthYear($user, $d[2], $d[3])->id;
                }

                // create category
                if ($this->categoryService->checkIsExist($user, trim($d[4]), trim($d[6]))) {
                    $categoryId = $this->categoryService->getByNameAndType($user, trim($d[4]), trim($d[6]))->id;
                } else {
                    $categoryId = $this->categoryService->createGetId($user, trim($d[4]), trim($d[6]));
                }

                $transactionDomain = new TransactionDomain();
                $transactionDomain->userId = $user->id;
                $transactionDomain->categoryId = $categoryId;
                $transactionDomain->periodId = $periodId;
                $transactionDomain->date = mktime(0, 0, 0, $d[2], $d[1], $d[3]);
                $transactionDomain->description = trim($d[5]);
                $transactionDomain->income = trim(strtolower($d[6])) == 'income' ? $d[7] : 0;
                $transactionDomain->spending = trim(strtolower($d[6])) == 'spending' ? $d[7] : 0;

                $this->transactionService->create($user, $transactionDomain);
            }

            Log::info('do import success');
            DB::commit();

            Session::flash('alert-success', "Transaksi berhasil di generate.");

            return redirect('/generate');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('do import failed', [
                'message' => $th->getMessage()
            ]);

            Session::flash('alert-success', "Transaksi gagal di generate.");

            return redirect('/generate-data');
        }
    }

    public function render()
    {
        return view('livewire.generate-data.form-import');
    }
}
