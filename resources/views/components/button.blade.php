<button
    {{ $attributes->merge(["type" => "submit", "class" => "inline-flex items-center px-4 py-2 bg-sky-600 dark:bg-sky-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-100 uppercase tracking-widest hover:bg-sky-700 dark:hover:bg-sky-800 focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"]) }}
>
    {{ $slot }}
</button>
