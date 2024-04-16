<div>
    <ul
        role="list"
        class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8"
    >
        @foreach ($snapshots as $snapshot)
            <li class="relative">
                <div
                    class="aspect-h-7 aspect-w-10 group block w-full overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100"
                >
                    <img
                        src="{{ $snapshot->getUrl() }}"
                        alt=""
                        class="pointer-events-none object-cover group-hover:opacity-75"
                    />
                    <button
                        wire:click="download({{ $snapshot->id }})"
                        type="button"
                        class="absolute inset-0 focus:outline-none"
                    >
                        <span class="sr-only">
                            View details for {{ $snapshot->name }}
                        </span>
                    </button>
                </div>
                <p
                    class="pointer-events-none mt-2 block truncate text-sm font-medium text-gray-900 dark:text-gray-200"
                >
                    {{ $snapshot->name }}
                </p>
                <p
                    class="pointer-events-none block text-sm font-medium text-gray-500"
                >
                    {{ \Illuminate\Support\Number::fileSize($snapshot->size) }}
                </p>
            </li>
        @endforeach
    </ul>

    @if ($hasMorePages)
        <x-section-border />

        <x-button
            class="mb-20 w-full justify-center py-4"
            wire:click.prevent="loadMore"
        >
            Load more
        </x-button>
    @endif

    <div
        x-data="{
        observe () {
            let observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        @this.call('loadMore')
                    }
                })
            }, {
                root: null
            })

            observer.observe(this.$el)
        }
    }"
        x-init="observe"
    ></div>
</div>
