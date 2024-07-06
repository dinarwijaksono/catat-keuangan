<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('migrate:fresh-test', function () {

    config(['database.default' => 'mysql-test']);

    Artisan::call('migrate:fresh');

    $this->comment("Migrate database test success....");
})->purpose('Run migrate to database test');

Artisan::command('tailwind-start', function () {
    system("npx tailwind -i ./resources/css/app.css -o ./public/asset/zara/style.css --watch");
})->purpose("Runing tailwind");
