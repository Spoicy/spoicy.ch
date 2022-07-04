@php
use App\Http\Controllers\GitHub;
@endphp
<div class="entry-link">
    <a href="https://github.com/{{$entry->author}}">{{$entry->author}}</a> pushed to <a href="https://github.com/{{$entry->entrydata->repo}}/tree/{{$entry->entrydata->branch}}">{{$entry->entrydata->branch}}</a> in <a href="https://github.com/{{$entry->entrydata->repo}}">{{$entry->entrydata->repo}}</a>
    <span>{{GitHub::getDateFormat($entry->date)}}</span>
</div>
<div class="entry-actions">
    @if (count($entry->entrydata->commits) > 1)
        <span>{{count($entry->entrydata->commits)}} commits to </span><a href="https://github.com/{{$entry->entrydata->repo}}/tree/{{$entry->entrydata->branch}}">{{$entry->entrydata->branch}}</a>
    @else
        <span>1 commit to </span><a href="https://github.com/{{$entry->entrydata->repo}}/tree/{{$entry->entrydata->branch}}">{{$entry->entrydata->branch}}</a>
    @endif
    <ul>
        @foreach ($entry->entrydata->commits as $commit)
            <li>
                <a href="{{$commit->link}}">{{$commit->id}} </a><span>{{$commit->message}}</span>
            </li>
        @endforeach
    </ul>
</div>