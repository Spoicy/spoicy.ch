<h2>GitHub</h2>
@foreach ($data as $entry)
    <div class="entry">
        <h3><a href="{{$entry->link}}">{{$entry->title}}</a></h3>
        <div class="entry-main">
            @include('components.media.github.'.strtolower($entry->type), ['entry' => $entry])
        </div>
    </div>
@endforeach