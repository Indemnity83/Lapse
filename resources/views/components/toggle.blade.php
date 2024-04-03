@props([
    "checked",
    "id",
])

<button
    type="button"
    role="switch"
    aria-checked="{{ $checked }}"
    aria-labelledby="{{ $id }}"
    {!! $attributes->merge(["class" => "mb-2 flex items-center"]) !!}
>
    <div
        class="{{ $checked ? "bg-sky-600 hover:bg-sky-700 dark:bg-sky-700 dark:hover:bg-sky-800" : "bg-sky-200 hover:bg-sky-300 dark:bg-gray-700 dark:hover:bg-gray-600" }} relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-sky-600 focus:ring-offset-2"
    >
        <span
            aria-hidden="true"
            class="{{ $checked ? "translate-x-5" : "translate-x-0" }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
        ></span>
    </div>
    <span class="ml-3 text-sm" id="{{ $id }}">
        <span class="font-medium text-gray-600 dark:text-gray-400">
            {{ $slot }}
        </span>
    </span>
</button>
