<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            update tanggal awal
        </h2>
    </header>

    <div class="mt-6 space-y-6">

        <div>
            <x-input-label for="update_start_date" :value="__('Tanggal awal')" />
            <select id="update_start_date" wire:model="date"
                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full mt-2">
                @for ($i = 1; $i < 32; $i++)
                    @if ($startDate->date == $i)
                        <option selected value="{{ $i }}">{{ $i }}
                        </option>
                    @else
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endif
                @endfor
            </select>

            @error('date')
                <p class="text-red-500 italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="button" wire:click="doUpdateStartDate"
                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Save</button>
        </div>
    </div>

</section>
