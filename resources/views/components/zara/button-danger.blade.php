<button
    {{ $attributes->merge([
        'class' => 'rounded-sm py-1 px-2 w-full bg-red-500 hover:bg-red-700 text-white text-[14px]',
    ]) }}>{{ $slot }}</button>
