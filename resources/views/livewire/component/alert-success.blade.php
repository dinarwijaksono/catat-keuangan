<div @class(['alert-success', 'hidden' => $isHidden])>
    <p>{{ $message }}</p>

    <div>
        <button type="button" wire:click="doHideAlert">Tutup</button>
    </div>
</div>
