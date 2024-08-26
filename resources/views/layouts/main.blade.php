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
                {{-- <div class="bg-red-100 shadow-sm  border border-red-400 text-red-700 px-4 py-3 rounded-sm mb-4 mx-4">
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Debitis, ad!</p>

                    <div class="flex justify-end">
                        <button
                            class="bg-red-500 hover:bg-red-700 text-white text-[13px] rounded-sm py-1 px-2">Tutup</button>
                    </div>
                </div> --}}

                @yield('main-section')

            </main>

    </body>

</html>
