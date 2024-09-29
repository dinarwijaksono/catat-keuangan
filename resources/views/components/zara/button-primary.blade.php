<button type="button"
    {{ $attributes->merge([
        'class' => 'bg-blue-500 hover:bg-blue-700 w-full text-white rounded-sm py-1 px-2 text-[14px]',
    ]) }}>{{ $slot }}</button>
