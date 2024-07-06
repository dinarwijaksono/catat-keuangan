<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('tailwind-start', function () {
    system("npx tailwind -i ./resources/css/app.css -o ./public/asset/zara/style.css --watch");
})->purpose("Runing tailwind");
