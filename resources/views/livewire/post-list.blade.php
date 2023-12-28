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
        <div class="mt-8 lg:mt-16">
            <button
                class="w-full p-4 bg-black text-white text-xl"
                wire:click="loadMore"
            >
                Load more
            </button>
        </div>
    @endif

</div>
