@php
use App\Http\Controllers\GitHub;
@endphp
<div class="entry-link">
    <a href="https://github.com/{{$entry->author}}">{{$entry->author}}</a> {{$entry->entrydata->issuetype}} an issue in <a href="https://github.com/{{$entry->entrydata->repo}}">{{$entry->entrydata->repo}}</a>
    <span>{{GitHub::getDateFormat($entry->date)}}</span>
</div>
<div class="entry-actions">
    <a href="{{$entry->link}}">{{$entry->entrydata->issuename}}</a><span> #{{$entry->entrydata->issuenum}}</span>
</div>