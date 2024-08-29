<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catat Keuangan</title>

        {{-- css zara --}}
        <link rel="stylesheet" href="/asset/zara/style.css">

    </head>

    <body class="bg-gray-100 text-gray-900">

        <div class="flex justify-center bg-zinc-400">
            <main class="w-full md:w-5/12 bg-zinc-100 min-h-screen">

                @livewire('component.navbar')

                <!-- Alert -->
                @livewire('component.alert-success')

                @yield('main-section')

            </main>

    </body>

</html>
