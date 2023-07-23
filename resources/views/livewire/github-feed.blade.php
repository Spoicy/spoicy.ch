@php
    $collection = ['Push', 'Watch', 'Issue']
@endphp

<div>
    <div class="filter-buttons">
        @foreach ($collection as $item)
            <button wire:click="changeEvent('{{$item}}')" class="btn {{ $item == $mode ? 'active' : ''}}" name="changeEvent{{$item}}" id="changeEvent{{$item}}" value="{{$item}}">{{$item}}</button>
        @endforeach
    </div>
    @foreach ($feed as $entry)
        @php
            $entry->entrydata = json_decode($entry->entrydata);
        @endphp
        <div class="entry">
            <h3><a href="{{$entry->link}}">{{$entry->title}}</a></h3>
            <div class="entry-main">
                @include('components.media.github.'.strtolower($entry->type), ['entry' => $entry])
            </div>
        </div>
    @endforeach
</div>
