@props(['active' => false])

<a {{ $attributes }} class="{{ $active
    ? 'bg-gray-800 text-white shadow'
    : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} px-4 py-2 rounded-md text-base font-semibold transition"
>
    {{ $slot }}
</a>
