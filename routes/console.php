<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('migrate-test', function () {

    config(['database.default' => 'mysql-test']);

    Artisan::call('migrate --path=/database/migrations/0001_01_01_000000_create_users_table.php');
    Artisan::call('migrate --path=/database/migrations/0001_01_01_000001_create_cache_table.php');
    Artisan::call('migrate --path=/database/migrations/0001_01_01_000002_create_jobs_table.php');
    Artisan::call('migrate --path=/database/migrations/2024_07_06_142925_create_start_dates_table.php');
    Artisan::call('migrate --path=/database/migrations/2024_07_07_122129_create_categories_table.php');
    Artisan::call('migrate --path=/database/migrations/2024_07_13_023331_create_periods_table.php');
    Artisan::call('migrate --path=/database/migrations/2024_07_13_113211_create_transactions_table.php');
    Artisan::call('migrate --path=/database/migrations/2024_10_02_150535_create_api_tokens_table.php');

    $this->comment("Migrate database test success....");
});

Artisan::command('migrate:fresh-test', function () {

    config(['database.default' => 'mysql-test']);

    Artisan::call('migrate:rollback --path=/database/migrations/0001_01_01_000000_create_users_table.php');
    Artisan::call('migrate:rollback --path=/database/migrations/0001_01_01_000001_create_cache_table.php');
    Artisan::call('migrate:rollback --path=/database/migrations/0001_01_01_000002_create_jobs_table.php');
    Artisan::call('migrate:rollback --path=/database/migrations/2024_07_06_142925_create_start_dates_table.php');
    Artisan::call('migrate:rollback --path=/database/migrations/2024_07_07_122129_create_categories_table.php');
    Artisan::call('migrate:rollback --path=/database/migrations/2024_07_13_023331_create_periods_table.php');
    Artisan::call('migrate:rollback --path=/database/migrations/2024_07_13_113211_create_transactions_table.php');
    Artisan::call('migrate:rollback --path=/database/migrations/2024_10_02_150535_create_api_tokens_table.php');

    Artisan::call('migrate --path=/database/migrations/0001_01_01_000000_create_users_table.php');
    Artisan::call('migrate --path=/database/migrations/0001_01_01_000001_create_cache_table.php');
    Artisan::call('migrate --path=/database/migrations/0001_01_01_000002_create_jobs_table.php');
    Artisan::call('migrate --path=/database/migrations/2024_07_06_142925_create_start_dates_table.php');
    Artisan::call('migrate --path=/database/migrations/2024_07_07_122129_create_categories_table.php');
    Artisan::call('migrate --path=/database/migrations/2024_07_13_023331_create_periods_table.php');
    Artisan::call('migrate --path=/database/migrations/2024_07_13_113211_create_transactions_table.php');
    Artisan::call('migrate --path=/database/migrations/2024_10_02_150535_create_api_tokens_table.php');

    $this->comment("Migrate database test success....");
})->purpose('Run migrate to database test');

Artisan::command('tailwind:start', function () {
    system("npx tailwind -i ./resources/css/app.css -o ./public/asset/zara/style.css --watch");
})->purpose("Runing tailwind");
