<div class="container max-w-2xl mx-auto space-y-8 mt-8 min-h-screen">
    @for ($i = 0; $i < $page && $i < $maxPage; $i++)
        @livewire(
            'post-list-items',
            [
                'postIds' => $postIdChunks[$i],
            ],
            key("chunk-{$queryCount}-{$i}")
        )
    @endfor

    @if ($this->hasNextPage())
        <div class="mt-8 lg:mt-16 flex flex-col items-center">
            <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 "  wire:click="loadMore">Show More</button>
        </div>
    @endif

</div>
