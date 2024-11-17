<section class="mb-4 shadow-lg shadow-slate-300 hover:shadow-slate-500 border-l-4 border-blue-400 rounded-lg p-4">

    <div class="mb-4">
        <h3 class="title">Import dari file CSV</h3>
    </div>

    <div class="mb-4">

        <x-zara.button-primary wire:click="doDownloadFormat">Download Format</x-zara.button-primary>

        <hr class="my-4">

        <div class="form-group">
            <label for="file">File</label>
            <input type="file" wire:model="file" id="file">
            <x-zara.text-error :name="__('file')" />
        </div>

        <div class="form-group flex justify-end">
            <div class="basis-3/12">
                <x-zara.button-primary wire:click="doImport">Import data</x-zara.button-primary>
            </div>
        </div>

    </div>

</section>
