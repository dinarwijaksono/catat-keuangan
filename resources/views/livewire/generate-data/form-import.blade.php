<section class="box">
    <div class="box-header mb-4">
        <h3 class="title">Import dari file CSV</h3>
    </div>

    <div class="box-body">

        <x-zara.button-primary wire:click="doDownloadFormat">Download Format</x-zara.button-primary>

        <hr class="my-4">

        <div class="form-group">
            <label for="file">File</label>
            <input type="file" id="file">
            <x-zara.text-error :name="__('file')" />
        </div>

        <div class="form-group flex justify-end">
            <div class="basis-3/12">
                <x-zara.button-primary>Import data</x-zara.button-primary>
            </div>
        </div>

    </div>

</section>
