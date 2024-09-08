<button
    {{ $attributes->merge([
        'class' =>
            'rounded-sm py-1 px-2 w-full border border-blue-500 bg-blue-100 hover:bg-blue-700 text-blue-500 hover:text-white text-[14px]',
    ]) }}>{{ $slot }}</button>
