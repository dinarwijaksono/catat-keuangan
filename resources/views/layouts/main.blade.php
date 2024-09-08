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

                @if (env('APP_ENV') != 'production')
                    <div class="bg-yellow-400 italic text-slate-700 underline p-2 text-center text-[14px]">
                        Aplikasi ini berjalan pada <b>mode test</b>
                    </div>
                @endif

                @livewire('component.navbar')

                <!-- Alert -->
                @if (session()->has('success'))
                    @livewire('component.alert-success', [
                        'message' => session()->get('success'),
                        'isHidden' => false,
                    ])
                @endif

                @livewire('component.alert-success')
                @livewire('component.alert-danger')

                @yield('main-section')

            </main>

    </body>

</html>
