<nav class="px-4 py-2 bg-teal-600 text-white mb-4">
    <div class=" mb-4 flex">
        <p class="basis-6/12 font-semibold text-[16px]">{{ env('APP_NAME') }}</p>
        <p class="basis-6/12 text-[14px] text-right">Hello, <a href="/profile" class="text-white italic font-semibold">{{ auth()->user()->name }}</a></p>
    </div>

    <div class="flex gap-1">
        <a href="/" class="basis-4/12 text-[14px] bg-sky-700 hover:bg-sky-500 py-1 text-center">Beranda</a>
        <a href="/report" class="basis-4/12 text-[14px] bg-sky-700 hover:bg-sky-500 py-1 text-center">Laporan</a>
        <a href="/setting" class="basis-4/12 text-[14px] bg-sky-700 hover:bg-sky-500 py-1 text-center">Setting</a>
    </div>
</nav>