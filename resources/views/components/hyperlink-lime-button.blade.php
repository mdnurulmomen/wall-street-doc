@props([
    'href'
])

<a href="{{ $href }}" class="text-white bg-lime-700 hover:bg-lime-800 focus:ring-4 focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-lime-600 dark:hover:bg-lime-700 focus:outline-none dark:focus:ring-lime-800">
    {{ $slot }}
</a>


