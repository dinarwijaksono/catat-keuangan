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

                <li><a href="/category" @class([
                    'block py-3 px-8 rounded-y rounded-r-full',
                    'bg-orange-200' => request()->path() == 'category',
                    'hover:bg-gray-300' => request()->path() != 'category',
                ])>Kategori</a>
                </li>

                <li><a href="/report" @class([
                    'block py-3 px-8 rounded-y rounded-r-full',
                    'bg-orange-200' => request()->path() == 'report',
                    'hover:bg-gray-300' => request()->path() != 'report',
                ])>Laporan</a>
                </li>

            </ul>
        </aside>
    </div>
</sidebar>
