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
        class="{{ $checked ? "bg-gray-600" : "bg-gray-200" }} relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
    >
        <span
            aria-hidden="true"
            class="{{ $checked ? "translate-x-5" : "translate-x-0" }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
        ></span>
    </div>
    <span class="ml-3 text-sm" id="{{ $id }}">
        <span class="font-medium text-gray-900">
            {{ $slot }}
        </span>
    </span>
</button>
