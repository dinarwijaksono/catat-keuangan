<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Keuangan</title>

    {{-- css zara --}}
    <link rel="stylesheet" href="/asset/zara/style.css">

</head>

<body class="bg-gray-50">

    @livewire('component.navbar')

    <div class="flex mt-24">

        @livewire('component.sidebar', ['fullPath' => request()->path()])

        <main class="basis-9/12 p-6">
            <div class="max-w-3xl mx-auto">
                @yield('main-section')
            </div>
        </main>

    </div>

</body>

</html>
