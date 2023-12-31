<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostList extends Component
{
    const ITEMS_PER_PAGE = 10;

    public $postIdChunks = [];

    public $page = 1;

    public $maxPage = 1;

    public $queryCount = 0;

    public function mount()
    {
        $this->prepareChunks();
    }

    public function render()
    {
        return view('livewire.post-list');
    }

    public function loadMore()
    {
        if ($this->hasNextPage()) {
            $this->page++;
        }
    }

    public function prepareChunks()
    {
        $this->postIdChunks = Post::query()
            ->orderByDesc('created_at')
            ->pluck('id')
            ->chunk(self::ITEMS_PER_PAGE)
            ->toArray();

        $this->maxPage = count($this->postIdChunks);

        $this->queryCount++;
        //dd($this->postIdChunks);
    }

    public function hasNextPage()
    {
        return $this->page < $this->maxPage;
    }
}
