<?php

namespace App\Http\Livewire;

use App\Models\GithubEvent;
use Livewire\Component;

class GithubFeed extends Component
{
    public $mode = 'All';
    public function render()
    {
        if ($this->mode == 'All') {
            $feed = GithubEvent::orderby('date', 'desc')->take(4)->get();
        } else {
            $feed = GithubEvent::where('type', $this->mode)->orderby('date', 'desc')->take(4)->get();
        }
        return view('livewire.github-feed', ['feed' => $feed]);
    }

    public function changeEvent($eventType) {
        if ($this->mode == $eventType) {
            $this->mode = 'All';
        } else {
            $this->mode = $eventType;
        }
    }
}
