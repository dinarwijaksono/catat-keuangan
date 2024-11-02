<nav class="fixed top-0 right-0 left-0 z-40 shadow-lg">

    @if (env('APP_ENV') != 'production')
        <div class="bg-yellow-300 w-full h-8 p-1 text-red-500">
            <p class="text-center underline italic font-semibold">** Aplikasi ini berjalan pada mode test **</p>
        </div>
    @endif

    <div class="bg-blue-500 p-2 h-14 w-full">
        <div class="flex items-center justify-between">
            <div class="text-white text-xl font-semibold">
                Catat Keuangan
            </div>

            <div class="flex items-center space-x-4">

                <ul>
                    <li class="inline-block text-white px-1">
                        {{ auth()->user()->name }}
                    </li>

                    <li class="inline-block text-white px-1">
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded-md">Logout</button>
                        </form>
                    </li>
                </ul>


            </div>
        </div>
    </div>
</nav>
