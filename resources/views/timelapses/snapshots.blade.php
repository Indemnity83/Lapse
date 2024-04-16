<x-app-layout>
    <x-slot name="header">
        <nav class="flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-2">
                <li>
                    <div class="flex items-center">
                        <a
                            href="{{ route("timelapses.show", $timelapse) }}"
                            class="text-xl font-semibold leading-tight text-gray-800 hover:text-gray-600 dark:text-gray-200"
                        >
                            {{ $timelapse->name }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg
                            class="h-6 w-6 flex-shrink-0 text-gray-400"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <a
                            href="{{ route("timelapses.snapshots", ["timelapse" => $timelapse, "camera" => $camera]) }}"
                            class="ml-2 text-xl font-semibold leading-tight text-gray-800 hover:text-gray-600 dark:text-gray-200"
                            aria-current="page"
                        >
                            {{ $camera->name }}
                        </a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
        <div class="mt-10 sm:mt-0">
            @livewire("timelapses.snapshot-list", ["camera" => $camera, "timelapse" => $timelapse])
        </div>
    </div>
</x-app-layout>
