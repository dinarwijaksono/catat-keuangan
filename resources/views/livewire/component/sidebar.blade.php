<sidebar class="basis-3/12">

    <div class="fixed min-h-screen w-3/12">

        <aside class="py-4 space-y-4">
            <ul class="mt-6">
                <li>
                    <a href="/" @class([
                        'block py-3 px-8 rounded-y rounded-r-full',
                        'bg-orange-200' => request()->path() == '/',
                        'hover:bg-gray-300' => request()->path() != '/',
                    ])>Beranda</a>
                </li>

                <li><a href="/" class="block py-3 px-8 hover:bg-gray-300 rounded-y rounded-r-full">Kategori</a>
                </li>

                <li><a href="/" class="block py-3 px-8 hover:bg-gray-300 rounded-y rounded-r-full">Laporan</a>
                </li>

            </ul>
        </aside>
    </div>
</sidebar>
