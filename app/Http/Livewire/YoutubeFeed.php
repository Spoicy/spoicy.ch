<?php

namespace App\Http\Livewire;

use App\Models\YoutubeVideo;
use Livewire\Component;

class YoutubeFeed extends Component
{
    public $filter = 'Latest';
    public $videos;
    public function render()
    {
        if ($this->filter == 'Popular') {
            $this->videos = YoutubeVideo::orderby('views', 'desc')->take(5)->get();
        } else {
            $this->videos = YoutubeVideo::orderby('date', 'desc')->take(5)->get();
        }
        return view('livewire.youtube-feed');
    }

    public function changeFilter($filter) {
        $this->filter = $filter;
    }
}
