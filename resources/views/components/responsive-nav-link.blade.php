@props([
    "active",
])

@php
    $classes =
        $active ?? false
            ? "block w-full border-l-4 border-sky-400 bg-sky-50 py-2 pe-4 ps-3 text-start text-base font-medium text-sky-700 transition duration-150 ease-in-out focus:border-sky-700 focus:bg-sky-100 focus:text-sky-800 focus:outline-none dark:border-sky-600 dark:bg-sky-900/50 dark:text-sky-300 dark:focus:border-sky-300 dark:focus:bg-sky-900 dark:focus:text-sky-200"
            : "block w-full border-l-4 border-transparent py-2 pe-4 ps-3 text-start text-base font-medium text-gray-600 transition duration-150 ease-in-out hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800 focus:border-gray-300 focus:bg-gray-50 focus:text-gray-800 focus:outline-none dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-200 dark:focus:border-gray-600 dark:focus:bg-gray-700 dark:focus:text-gray-200";
@endphp

<a {{ $attributes->merge(["class" => $classes]) }}>
    {{ $slot }}
</a>
