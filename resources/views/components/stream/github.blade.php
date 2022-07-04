@php
use App\Http\Controllers\GitHub;
@endphp
<h2>GitHub</h2>
@foreach ($variables['githubEntries'] as $key => $entry)
    @php
        $entry->entrydata = json_decode($entry->entrydata);
    @endphp
    <div class="entry">
        <h3><a href="{{$entry->link}}">{{$entry->title}}</a></h3>
        <div class="entry-main">
            @include('components.stream.github.'.strtolower($entry->type), ['entry' => $entry])
        </div>
    </div>
@endforeach