<div @class(['alert-danger', 'hidden' => $isHidden])>
    <p>{{ $message }}</p>

    <div>
        <button type="button" wire:click="doHideAlert">Tutup</button>
    </div>
</div>
